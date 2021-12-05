<?php

namespace App;

use App\Scopes\AgentScope;
use App\Traits\Auditable;
use App\Notifications\CommentEmailNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Ticket extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable;

    public $table = 'tickets';

    protected $appends = [
        'attachments',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'content',
        'status_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'priority_id',
        'category_id',
        'author_name',
        'author_email',
        'assigned_to_user_id',
        'value'
    ];

    public static function boot()
    {
        parent::boot();

        Ticket::observe(new \App\Observers\TicketActionObserver);

        static::addGlobalScope(new AgentScope);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'ticket_id', 'id');
    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function assigned_to_user()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function scopeFilterPriority(Builder $query, ?int $priority_id)
    {
        $query->when($priority_id, function ($query) use ($priority_id) {
            $query->whereHas('priority', fn ($query) => $query->whereId($priority_id));
        });
    }

    public function scopeFilterCategory(Builder $query, ?int $category_id)
    {
        $query->when($category_id, function ($query) use ($category_id) {
            $query->whereHas('category', fn ($query) => $query->whereId($category_id));
        });
    }

    public function scopeFilterStatus(Builder $query, ?int $status_id)
    {
        if ($status_id) {
            $query->whereHas('status', function ($query) use ($status_id) {
                $query->whereId($status_id);
            });
        } else {
            $query->whereNotIn('status_id', [2,4]);
        }
    }

    public function scopeFilterMinDate(Builder $query, ?string $date)
    {
        $query->when($date, function ($query) use ($date) {
            return $query->whereDate(
                'created_at',
                '>=',
                Carbon::parse($date)->toDateTimeString()
            );
        });
    }

    public function scopeFilterMaxDate(Builder $query, ?string $date)
    {
        $query->when($date, function ($query) use ($date) {
            return $query->whereDate(
                'created_at',
                '<=',
                Carbon::parse($date)->toDateTimeString()
            );
        });
    }

    public function sendCommentNotification($comment)
    {
        $users = \App\User::where(function ($q) {
            $q->whereHas('roles', function ($q) {
                return $q->where('title', 'Agent');
            })->where(function ($q) {
                $q->whereHas('comments', function ($q) {
                    return $q->whereTicketId($this->id);
                })->orWhereHas('tickets', function ($q) {
                    return $q->whereId($this->id);
                });
            });
        })->when(!$comment->user_id && !$this->assigned_to_user_id, function ($q) {
            $q->orWhereHas('roles', function ($q) {
                return $q->where('title', 'Admin');
            });
        })->when($comment->user, function ($q) use ($comment) {
            $q->where('id', '!=', $comment->user_id);
        })->get();
        $notification = new CommentEmailNotification($comment);

        Notification::send($users, $notification);
        if ($comment->user_id && $this->author_email) {
            Notification::route('mail', $this->author_email)->notify($notification);
        }
    }
}

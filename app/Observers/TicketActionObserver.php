<?php

namespace App\Observers;

use App\Notifications\DataChangeEmailNotification;
use App\Notifications\AssignedTicketNotification;
use App\Notifications\UpdateDataEmailNotification;
use App\Ticket;
use Illuminate\Support\Facades\Notification;

class TicketActionObserver
{
    public function created(Ticket $model)
    {
        $data  = ['action' => 'Nova OS criada!', 'model_name' => 'Ticket', 'ticket' => $model];
        $users = \App\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin')->orWhere('title', 'Gerente');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function updated(Ticket $model)
    {
        if($model->isDirty('assigned_to_user_id'))
        {
            $user = $model->assigned_to_user;
            if($user)
            {
                Notification::send($user, new AssignedTicketNotification($model));
            }
        }

        if($model->author_email)
            Notification::route('mail', $model->author_email)->notify(new UpdateDataEmailNotification($model));
    }
}

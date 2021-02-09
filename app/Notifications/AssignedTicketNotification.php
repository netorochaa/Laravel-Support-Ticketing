<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignedTicketNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('manutencao.rds@roseannedore.com.br', 'Manutenção - Roseanne Dore')
                    ->subject('Você recebeu uma nova OS!')
                    ->greeting('Olá,')
                    ->line('Você recebeu a seguinte OS: '.$this->ticket->title)
                    ->action('Clique aqui para acessá-la', route('admin.tickets.show', $this->ticket->id))
                    ->line('Obrigado!')
                    ->salutation(' ');
    }
}

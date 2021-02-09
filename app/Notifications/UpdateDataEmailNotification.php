<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class UpdateDataEmailNotification extends Notification
{
    use Queueable;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return $this->getMessage($notifiable);
    }

    public function getMessage($notifiable)
    {
        return (new MailMessage)
            ->from('manutencao.rds@roseannedore.com.br', 'Manutenção - Roseanne Dore')
            ->subject('OS foi atualizada')
            ->greeting('Olá, sua OS foi atualizada:')
            ->line("Requerente: ".$this->ticket->author_name) 
            ->line("Título: ".$this->ticket->title)
            ->action('Clique aqui para ver a OS completa', route('tickets.show', $this->ticket->id))
            ->line('Obrigado!')
            ->salutation(' ');
    }
}

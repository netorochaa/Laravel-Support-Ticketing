<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class DataChangeEmailNotification extends Notification
{
    use Queueable;

    public function __construct($data)
    {
        $this->data = $data;
        $this->ticket = $data['ticket'];
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return $this->getMessage();
    }

    public function getMessage()
    {
        return (new MailMessage)
            ->from('manutencao.rds@roseannedore.com.br', 'Manutenção - Roseanne Dore')
            ->subject($this->data['action'])
            ->greeting('Olá,')
            ->line($this->data['action'])
            ->line("Requerente: ".$this->ticket->author_name) 
            ->line("Título: ".$this->ticket->title)
            ->line("Descrição: ".Str::limit($this->ticket->content, 200))
            ->action('Clique aqui para acessá-lo', route('admin.tickets.show', $this->ticket->id))
            ->line('Obrigado!')
            ->line('Time ' . config('app.name'))
            ->salutation(' ');
    }
}

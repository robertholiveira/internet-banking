<?php

namespace InternetBanking\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerificacaoDeCliente extends Notification
{
    use Queueable;

    public $cliente;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($cliente)
    {
        $this->cliente = $cliente;
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
                    ->subject('Verificação de e-mail')
                    ->greeting('Olá, '. $this->cliente->name)
                    ->salutation('Até mais!')
                    ->line('agradecemos muito pelo seu cadastro em nossa conta digital, seu último passo é verificar seu e-mail, clique no botão abaixo para verificar:')
                    ->action('Verificar e-mail', url('cliente/verificacaoCliente', $this->cliente->VerificarCliente->token))
                    ->line('Obrigado por usar nossa conta digital!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

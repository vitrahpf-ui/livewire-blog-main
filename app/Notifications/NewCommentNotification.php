<?php

namespace App\Notifications;

use Dom\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Comment $comment)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject(subject: 'New comment on your post' . $this->comment->post->title)
            ->greeting('Hello' . $notifiable->name . '!')
            ->line('Someone has comment on your post.' .$this->comment->title)
            ->line('**' . $this->comment->user->name . '**')
            ->line('**' . $this->comment->content . '**')
            ->action('View Comment', url:route(name:'blog.show', parameters: $this->comment->post->slug))
            ->line('Thank you for creating great comment!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

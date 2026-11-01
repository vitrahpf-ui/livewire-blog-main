<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPOstPublished extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Post $post)
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
        ->subject(subject: 'New post: ' . $this->post->title)
        ->greeting(greeting: 'Hello!')
        ->line(line: 'A new post has been published on ' . config(key: 'app.name'))
        ->line(line: '**' . $this->post->title . '**')
        ->line(line: $this->post->excerpt ?? 'Click below to read the full post.')
        ->action(text: 'Read Post', url: route(name: 'blog.show', parameters: $this->post->slug))
        ->line(line: 'Thank you for being a subscriber!')
        ->line(line: '[Unsubscribe]('.route(name: 'unsubscribe', parameters: $notifiable->token).')');
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

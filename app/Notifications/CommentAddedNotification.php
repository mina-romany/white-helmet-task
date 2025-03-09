<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentAddedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $comment,
                                public $task,
                                public $commenter)
    {}

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
        ->subject("New Comment on Your Task: {$this->task->title}")
        ->line("{$this->commenter->name} commented on your task:")
        ->line($this->comment->body)
        ->action('View Task', url("/tasks/{$this->task->id}"))
        ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'comment_id' => $this->comment->id,
            'commenter_id' => $this->commenter->id,
            'message' => "{$this->commenter->name} commented on your task: {$this->task->title}",
        ];
    }
}

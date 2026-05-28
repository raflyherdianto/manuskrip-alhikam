<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;


class KaryaBaruNotification extends Notification
{
    use Queueable;
    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        $notificationData = [
            'karya_id' => $this->data['karya_id'],
            'admin_id' => $this->data['admin_id'] ?? null,
            'title' => $this->data['title'],
            'jurusan_id' => $this->data['jurusan_id'] ?? null,
        ];

        // Jika admin_id null, berarti notifikasi karya baru dari user
        if ($this->data['admin_id'] === null) {
            $notificationData['type'] = 'karya_new';
            $notificationData['user_id'] = $this->data['user_id'] ?? null;
        } else {
            // Jika admin_id ada, berarti karya dipublikasi oleh admin
            $notificationData['type'] = 'karya_published';
        }

        return $notificationData;
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

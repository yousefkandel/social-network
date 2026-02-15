<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue; // شلنا الـ Queue مؤقتًا
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class FriendRequestNotification extends Notification
{
    use Queueable;

    public $sender;

    public function __construct($sender)
    {
        $this->sender = $sender;
    }

    // طرق الإشعار: حفظ في DB + بث real-time
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    // البيانات لحفظها في جدول notifications
    public function toArray($notifiable)
    {
        return [
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'type' => 'friend_request'
        ];
    }

    // البيانات للبث real-time
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'type' => 'friend_request'
        ]);
    }
}

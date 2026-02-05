<?php
namespace App\Mail;

use App\Models\Notification_campaign;
use Illuminate\Mail\Mailable;

class NotificationCampaignMail extends Mailable
{
    public $notification;

    public function __construct(Notification_campaign $notification)
    {
        $this->notification = $notification;
    }

    public function build()
    {
        return $this->subject('New Notification Campaign')
                    ->view('emails.notification_campaign')  // استبدل بـ view البريد الإلكتروني المناسب
                    ->with([
                        'title' => $this->notification->title,
                        'body' => $this->notification->body,
                        'link' => $this->notification->link,
                    ]);
    }
}

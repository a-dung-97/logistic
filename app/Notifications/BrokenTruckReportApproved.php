<?php

namespace App\Notifications;

use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BrokenTruckReportApproved extends Notification
{
    use Queueable;
    protected $brokenTruckReport;
    public function __construct($brokenTruckReport)
    {
        $this->brokenTruckReport = $brokenTruckReport;
    }
    public function toOneSignal($notifiable)
    {
        return OneSignalMessage::create()
            ->subject("Báo cáo hỏng xe đã được duyệt")
            ->body("Ấn vào đây để xem chi tiết.")
            ->setData('data', $this->brokenTruckReport->toArray());
    }
    public function via($notifiable)
    {
        return [OneSignalChannel::class, 'database'];
    }

    public function toArray($notifiable)
    {
        return $this->brokenTruckReport->toArray();
    }
}

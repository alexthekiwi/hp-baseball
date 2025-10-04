<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class OrdersExportNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $filePath,
        public Carbon $since,
    ) {
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
        $sinceDate = $this->since->format('d/m/Y');
        $untilDate = now()->format('d/m/Y');

        return (new MailMessage)
            ->subject('Orders Export')
            ->greeting('Kia ora!')
            ->line("Attached is an export of orders between {$sinceDate} and {$untilDate}.")
            ->line('Please note: orders with multiple line items have been split across multiple rows. For bundles this means the sizing will be repeated across these rows.')
            ->attachData(Storage::get($this->filePath), basename($this->filePath))
            ->salutation('Cheers!');
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

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnrollmentSuccessNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $courseTitle
    )
    {
    }

    public function via($notifiable): array
    {
        // Send through multiple channels
        return ['mail', 'database']; // 'sms' custom channel added later
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("You’re enrolled in {$this->courseTitle}")
            ->line("Congratulations! You are now enrolled in {$this->courseTitle}.")
            ->action('View Course', url("/courses/{$this->courseTitle}"));
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'enrollment',
            'course' => $this->courseTitle,
            'message' => "You are enrolled in {$this->courseTitle}"
        ];
    }

    // Optional: SMS channel
    public function toSms($notifiable)
    {
        return [
            'phone' => $notifiable->phone_e164,
            'message' => "You’re enrolled in {$this->courseTitle}"
        ];
    }
}


<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountVerified extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $userEmail;
    public $passwordChanged;
    public $activityUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $userEmail, $passwordChanged, $activityUrl)
    {
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->passwordChanged = $passwordChanged;
        $this->activityUrl = $activityUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Akun Berhasil Diverifikasi - Manuskrip Digital Pesantren',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.account-verified',
            with: [
                'userName' => $this->userName,
                'userEmail' => $this->userEmail,
                'passwordChanged' => $this->passwordChanged,
                'activityUrl' => $this->activityUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

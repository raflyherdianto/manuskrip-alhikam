<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KaryaWaitingVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $karyaTitle;
    public $jenisKarya;
    public $kategori;
    public $uploadDate;
    public $activityUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $karyaTitle, $jenisKarya, $kategori, $uploadDate, $activityUrl)
    {
        $this->userName = $userName;
        $this->karyaTitle = $karyaTitle;
        $this->jenisKarya = $jenisKarya;
        $this->kategori = $kategori;
        $this->uploadDate = $uploadDate;
        $this->activityUrl = $activityUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Manuskrip Menunggu Verifikasi - ' . $this->karyaTitle,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.waiting-verification',
            with: [
                'userName' => $this->userName,
                'karyaTitle' => $this->karyaTitle,
                'jenisKarya' => $this->jenisKarya,
                'kategori' => $this->kategori,
                'uploadDate' => $this->uploadDate,
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

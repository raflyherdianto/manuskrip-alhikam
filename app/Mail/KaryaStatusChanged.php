<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KaryaStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $karyaTitle;
    public $jenisKarya;
    public $kategori;
    public $status;
    public $keterangan;
    public $updateDate;
    public $activityUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $karyaTitle, $jenisKarya, $kategori, $status, $keterangan, $updateDate, $activityUrl)
    {
        $this->userName = $userName;
        $this->karyaTitle = $karyaTitle;
        $this->jenisKarya = $jenisKarya;
        $this->kategori = $kategori;
        $this->status = $status;
        $this->keterangan = $keterangan;
        $this->updateDate = $updateDate;
        $this->activityUrl = $activityUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = match($this->status) {
            'Terpublish' => 'Manuskrip Terpublikasi',
            'Ditolak' => 'Manuskrip Ditolak',
            'Arsip' => 'Manuskrip Diarsipkan',
            default => 'Status Manuskrip Diperbarui'
        };

        return new Envelope(
            subject: $statusText . ' - ' . $this->karyaTitle,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.status-changed',
            with: [
                'userName' => $this->userName,
                'karyaTitle' => $this->karyaTitle,
                'jenisKarya' => $this->jenisKarya,
                'kategori' => $this->kategori,
                'status' => $this->status,
                'keterangan' => $this->keterangan,
                'updateDate' => $this->updateDate,
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

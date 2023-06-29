<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Manage;

class ReserveMailManage extends Mailable
{
    use Queueable, SerializesModels;

    public $reserve;
    public $reserve_detail;
    public $dental_data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reserve, $reserve_detail)
    {
        $this->reserve = $reserve;
        $this->reserve_detail = $reserve_detail;
        $dental_data = Manage::find($reserve['manage_id']);
        $this->dental_data = $dental_data;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'ご予約が入りました。',
            from: 'dental@example.net',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.reserve_manage',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}

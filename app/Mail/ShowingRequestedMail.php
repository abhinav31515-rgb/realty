<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class ShowingRequestedMail extends Mailable {
    use Queueable, SerializesModels;
    public function __construct(public $booking) {}
    public function envelope(): Envelope { return new Envelope(subject: 'New Private Showing Request'); }
    public function content(): Content { return new Content(view: 'emails.showing_requested'); }
}

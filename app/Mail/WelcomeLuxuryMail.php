<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class WelcomeLuxuryMail extends Mailable {
    use Queueable, SerializesModels;
    public function __construct(public $user) {}
    public function envelope(): Envelope { return new Envelope(subject: 'Welcome to the LuxeEstate Collection'); }
    public function content(): Content { return new Content(view: 'emails.welcome'); }
}

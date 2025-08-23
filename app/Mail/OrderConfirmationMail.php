<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load(['tour', 'payment']);
    }

    public function envelope(): Envelope
    {
        $subject = '[King Express Travel] Xác nhận đơn hàng #' . $this->order->id;
        if ($this->order->tour) {
            $subject .= ' - ' . $this->order->tour->name;
        }

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.order-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmployeeCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($id)
    {
        $this->user = User::findOrFail($id);
    }

    /**
     * @return EmployeeCreated
     */
    public function build()
    {
        return $this->subject('Welcome to the Team')
            ->view('emails.employee_created')
            ->with([
                'email' => $this->user->email,
            ]);
    }
}

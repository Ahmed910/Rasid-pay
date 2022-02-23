<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $optional;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data , array $optional = [])
    {
        $this->data = $data;
        $this->optional = $optional;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($optional['view'],['data' => $this->data])->subject(@$optional['subject'])->cc();
    }
}

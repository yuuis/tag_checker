<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $options;
    public $data;
    public $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($options, $data, $file)
    {
        $this->options = $options;
        $this->data = $data;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->options['from'], 
            $this->options['from_jp'])
                ->attach($this->file)
                ->subject($this->options['subject'])
                ->text($this->options['template']);
    }
}

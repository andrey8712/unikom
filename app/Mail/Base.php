<?php


namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Base extends Mailable
{

    use Queueable, SerializesModels;

    public $text;

    public function __construct($text = null)
    {
        $this->text = $text;
    }

    public function build()
    {
        $title = 'Заявка';

        return $this->subject($title)->view('emails.base')->attach('/var/www/unikom/storage/app/public/proxies/546.jpg', [
            'as' => 'proxy.jpg',
            'mime' => 'application/jpg',
        ]);
    }

}
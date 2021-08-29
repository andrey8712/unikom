<?php


namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Base extends Mailable
{

    use Queueable, SerializesModels;

    public $text;
    public $link;

    public function __construct($link, $text = null)
    {
        $this->link = $link;
        $this->text = $text;
    }

    public function build()
    {

        $title = 'Доверенность ' . $this->text;

        //return $this->subject($title)->view('emails.base')->attach('/var/www/unikom/storage/app/public/proxies/546.jpg', [
        return $this->subject($title)->view('emails.base')->attach(storage_path('app/public/'. $this->link), [
            'as' => $title . '.jpg',
            'mime' => 'application/jpg',
        ]);
    }

}
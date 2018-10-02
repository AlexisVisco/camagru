<?php

class Mailer
{

    private $subject;
    private $content;
    private $email;

    /**
     * Mailer constructor.
     * @param $subject
     * @param $content
     * @param $email
     */
    public function __construct($subject, $content, $email)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->email = $email;
    }

    /**
     * Because PHP is a poor language, we cant execute this
     * function asynchronously, so this function may block the website
     * for few seconds. This is ugly.
     *
     * In java for instance we can spawn a new thread
     * to not block the principal thread.
     *
     * @return bool return if true or false the mail was sent.
     */
    public function send() : bool {
        $to = $this->email;
        $subject = $this->subject;
        $txt = $this->content;
        $headers = "From: aviscogl.camagru.42@gmail.com";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        return (mail($to,$subject,$txt,$headers));
    }


}
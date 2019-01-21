<?php

class PictureComment implements FormValidation
{
    public $body;

    public function __construct($array)
    {
        foreach ($array as $key => $item) {
            $this->{$key} = $item;
        }
    }

    function validate(): bool
    {
       if (strlen($this->body) > 1000) {
           Messages::pictureCommentLength();
           return false;
       }
       return true;
    }
}
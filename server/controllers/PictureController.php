<?php


class PictureController extends BaseController
{
    function addPicture() {
        echo self::render("add_picture");
    }
}
<?php


class PictureController extends BaseController
{

    private $authorized_file = array('jpg' => 'image/jpeg', 'png' => 'image/png');
    private $max_file_size = 100000 * 10;

    function addPicture() {
        if (count($_POST) != 0 || count($_FILES) != 0) $this->postMountPicture();
        else echo self::render("add_picture");
    }

    function postMountPicture() {
         var_dump($_FILES);
         var_dump($_POST);
    }

    function addPictureUpload() {
        $f = $_FILES["userfile"];

        if (!isset($f['error']) || is_array($f['error'])) {
            Messages::pictureUploadInvalid();
            $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
        }

        if ($f["size"] > $this->max_file_size) {
            Messages::pictureUploadErrSize();
            $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
        }

        switch ($f['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                Messages::pictureUploadNoFileSent();
                $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
            case UPLOAD_ERR_INI_SIZE:
                Messages::pictureUploadInvalidSize();
                $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
            case UPLOAD_ERR_FORM_SIZE:
                Messages::pictureUploadErrSize();
                $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
            default:
                Messages::pictureUploadInvalid();
                $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search($finfo->file($f['tmp_name']), $this->authorized_file, true)) {
            Messages::pictureUploadErrType();
            $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
        }

        $type = pathinfo($f["tmp_name"], PATHINFO_EXTENSION);
        $data = file_get_contents($f["tmp_name"]);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        echo self::render("add_picture", ["fileb64" => $base64]);
    }
}
<?php


class PictureController extends BaseController
{

    private $authorized_file = array('jpg' => 'image/jpeg', 'png' => 'image/png');
    private $max_file_size = 100000 * 10;

    function addPicture()
    {
        if (!isset($_SESSION["user"])) $this->redirect("/" . Routes::$USER_LOGIN);
        else if (count($_POST) != 0) $this->postMountPicture();
        else {
            echo self::render("add_picture", ["fullheight" => "is-fullheight"]);
        }
    }


    function postMountPicture()
    {
        $ensure = $this->ensure(["raw", "has_composition"]);
        if (count($ensure) != 0) {
            Messages::shouldEnsure($ensure);
            echo self::render("add_picture");
        } else {
            $raw = str_replace("data:image/png;base64,", "", $_POST["raw"]);
            $decodedRaw = base64_decode($raw);
            $size = strlen($raw) / 1.37; // in bytes

            if ($size > $this->max_file_size) {
                Messages::pictureUploadInvalidSize();
                $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
            }

            $img = imagecreatefromstring($decodedRaw);
            if ($img == false) {
                Messages::pictureUploadError();
                $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
            }

            $filename = Storage::uuid() . '.png';
            imagepng($img, $filename);
            if ($_POST["has_composition"] == "true") {
                $compositionOpt = json_decode($_POST["composition_img"], true);
                $ensureComp = $this->ensureArr($compositionOpt, ["location", "desc"]);
                if (count($ensureComp) != 0) {
                    unlink($filename);
                    Messages::pictureUploadError();
                    $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
                } else {
                    $ensureDesc = $this->ensureArr($compositionOpt["desc"], ["dw", "dh"]);
                    if (count($ensureDesc) != 0) {
                        Messages::pictureUploadError();
                        $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
                    }
                }
                $alpha = imagecreatefrompng(ROOT . $compositionOpt["location"]);


                imagecopymerge($img, $alpha,
                    (imagesx($img) / 2) - (imagesx($alpha) / 2) + ($compositionOpt["desc"]["dw"]),
                    (imagesy($img) / 2) - (imagesy($alpha) / 2) + ($compositionOpt["desc"]["dh"]),
                    0, 0, 200, 200, 100);
                imagepng($img, $filename);
                imagedestroy($img);
                imagedestroy($alpha);

                $type = pathinfo($filename, PATHINFO_EXTENSION);
                $data = file_get_contents($filename);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                unlink($filename);

                $user = json_decode($_SESSION["user"]);
                $pic = new Picture();
                $pic->init($user->id, $base64);
                $pic->save();

                Messages::pictureUploadSuccess();
                $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
            } else {

            }
        }
    }

    function addPictureUpload()
    {
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
                break;
            case UPLOAD_ERR_INI_SIZE:
                Messages::pictureUploadInvalidSize();
                $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
                break;
            case UPLOAD_ERR_FORM_SIZE:
                Messages::pictureUploadErrSize();
                $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
                break;
            default:
                Messages::pictureUploadInvalid();
                $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
                break;
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


    function gallery()
    {
        $pictures = Picture::pictures(0, 9);
        foreach ($pictures as $picture) {
            $user = new User();
            $picture->likes = Like::likes($picture->id);
            $picture->hasLike = isset($_SESSION["user"]) ? Like::hasLike(json_decode($_SESSION["user"])->id, $picture->id) : false;
            $picture->comments = Comment::comments($picture->id);
            $picture->user = $user->load($picture->id_user);
        }
        echo self::render("gallery", ["pictures" => $pictures]);
    }

    function like($pictureId)
    {
        if (!isset($_SESSION["user"])) $this->redirect("/" . Routes::$USER_LOGIN);
        $user = json_decode($_SESSION["user"]);
        $hasLiked = Like::hasLike($user->id, $pictureId);
        if ($hasLiked) {
            $like = new Like();
            $like = $like->loadLike($user->id, $pictureId);
            $like->delete();
            $this->redirect("/" . Routes::$PICTURE_GALLERY);
        } else {
            $like = new Like();
            $like->init($pictureId, $user->id);
            $like->save();
            $this->redirect("/" . Routes::$PICTURE_GALLERY);
        }
    }
}
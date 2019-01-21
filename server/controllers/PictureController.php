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
            if ($_POST["has_composition"] == "true") {
                $compositionOpt = json_decode($_POST["composition_img"], true);
                $ensureComp = $this->ensureArr($compositionOpt, ["location", "desc"]);
                if (count($ensureComp) != 0) {
                    Messages::pictureUploadError();
                    $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
                } else {
                    $ensureDesc = $this->ensureArr($compositionOpt["desc"], ["dw", "dh"]);
                    if (count($ensureDesc) != 0) {
                        Messages::pictureUploadError();
                        $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
                    }
                }
                try {
                    $alpha = new Imagick();
                    if (false === $alpha->readImage(ROOT . $compositionOpt["location"])) throw new Exception("can't read alpha");

                    $face = new Imagick();
                    if (false === $face->readImageBlob($decodedRaw)) throw new Exception("can't read webcam image");

                    if (false === $face->compositeImage($alpha, Imagick::COMPOSITE_DEFAULT,
                            ($face->getImageWidth()/2) - ($alpha->getImageWidth()/2) + ($compositionOpt["desc"]["dw"]),
                            ($face->getImageHeight()/2) - ($alpha->getImageHeight()/2) + ($compositionOpt["desc"]["dh"])
                    ))
                        throw new Exception("can't merge two images");

                    $user = json_decode($_SESSION["user"]);
                    $pic = new Picture();
                    $pic->init($user->id, 'data:image/jpg;base64,'.base64_encode($face->getImageBlob()));
                    $pic->save();
                    Messages::pictureUploadSuccess();
                    $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
                } catch (Exception $e) {
                    $fm = new FlashMessage("Impossible de faire le traitement.", FlashType::$ERROR);
                    $fm->register();
                    $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
                }
            } else {
                try {
                    $face = new Imagick();
                    if (false === $face->readImageBlob($decodedRaw)) throw new Exception("can't read webcam image");

                    $user = json_decode($_SESSION["user"]);
                    $pic = new Picture();
                    $pic->init($user->id, 'data:image/jpg;base64,'.base64_encode($face->getImageBlob()));
                    $pic->save();
                    Messages::pictureUploadSuccess();
                    $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
                } catch (Exception $e) {
                    $fm = new FlashMessage("Impossible de faire le traitement.", FlashType::$ERROR);
                    $fm->register();
                    $this->redirect("/" . Routes::$PICTURE_ADD_PHOTO);
                }
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
            $picture->comments = Comment::countComments($picture->id);
            $picture->user = $user->load($picture->id_user);
        }
        echo self::render("gallery", ["pictures" => $pictures]);
    }

    function like($pictureId)
    {
        if (!isset($_SESSION["user"])) $this->redirect("/" . Routes::$USER_LOGIN);
        $picture = new Picture();
        $picture = $picture->loadWhere("id", $pictureId);
        if ($picture == null) {
            self::redirect("/" . Routes::$PICTURE_GALLERY);
        }
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

    function comment($pictureId)
    {
        if (count($_POST) == 0 || !isset($_SESSION["user"])) $this->redirect("/photo/" . $pictureId . "/");
        $picture = new Picture();
        $picture = $picture->loadWhere("id", $pictureId);
        if ($picture == null) {
            $this->redirect("/photo/" . $pictureId . "/");
        }
        $user = json_decode($_SESSION["user"]);
        $ensure = self::ensure(["body"]);
        if (count($ensure) != 0) Messages::shouldEnsure($ensure);
        $formComment = new PictureComment($_POST);
        if (!$formComment->validate()) $this->redirect("/photo/" . $pictureId . "/");

        $comment = new Comment();
        $comment->init($pictureId, $user->id, $_POST["body"]);
        $comment->save();
        Messages::pictureCommentSuccess();
        $this->redirect("/photo/" . $pictureId . "/");
    }

    function picture($pictureId)
    {
        $picture = new Picture();
        $picture = $picture->loadWhere("id", $pictureId);
        if ($picture == null) {
            self::redirect("/" . Routes::$PICTURE_GALLERY);
        }
        $user = new User();
        $picture->likes = Like::likes($picture->id);
        $picture->hasLike = isset($_SESSION["user"]) ? Like::hasLike(json_decode($_SESSION["user"])->id, $picture->id) : false;
        $picture->comments = Comment::countComments($picture->id);
        $picture->user = $user->load($picture->id_user);

        $comments = Comment::comments($pictureId);
        $comments = $comments != null ? $comments : [];
        foreach ($comments as $comment) {
            $user = new User();
            $comment->user = $user->load($comment->id_user);
        }
        echo self::render("picture", ["picture" => $picture, "comments" => $comments]);
    }
}
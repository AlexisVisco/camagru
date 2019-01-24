<?php

class Routes {

    public static $HOME = "";
    public static $SETUP = "setup/";

    public static $USER_CONFIRM = "confirmation/(.+)/(.+)/";
    public static $USER_REGISTER = "inscription/";
    public static $USER_LOGOUT = "deconnexion/";
    public static $USER_LOGIN = "connexion/";
    public static $USER_FORGOT_PWD = "mot-de-passe-oublie/";
    public static $USER_CHANGE_PWD = "changer-de-mot-de-passe/(.+)/(.+)/";
    public static $USER_SETTINGS = "preferences/";

    public static $PICTURE_LIKE = "like/(.+)/";
    public static $PICTURE_MY_PICTURES = "mes-photos/";
    public static $PICTURE_DELETE = "supprimer-photo/(.+)/";
    public static $PICTURE_COMMENT = "comment/(.+)/";
    public static $PICTURE_DESC = "photo/(.+)/";
    public static $PICTURE_ADD_PHOTO = "ajouter-une-photo/";
    public static $PICTURE_ADD_PHOTO_UPLOAD = "ajouter-une-photo/depuis-mon-pc/";
    public static $PICTURE_GALLERY = "gallerie/";

}
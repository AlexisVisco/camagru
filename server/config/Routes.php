<?php

class Routes {

    public static $HOME = "";

    public static $USER_CONFIRM = "confirmation/(.+)/(.+)/";
    public static $USER_REGISTER = "inscription/";
    public static $USER_LOGOUT = "deconnexion/";
    public static $USER_LOGIN = "connexion/";
    public static $USER_FORGOT_PWD = "mot-de-passe-oublie/";
    public static $USER_CHANGE_PWD = "changer-de-mot-de-passe/(.+)/(.+)/";

    public static $PICTURE_ADD_PHOTO = "ajouter-une-photo/";
    public static $PICTURE_ADD_PHOTO_UPLOAD = "ajouter-une-photo/depuis-mon-pc/";

}
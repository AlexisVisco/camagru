<?php

class Mails
{
    public static function userConfirmation(User $user, Token $token) {
        $url = URL;
        $m = new Mailer(
            "Camagru - Confirme ton compte!",
            "Bienvenue sur Camagru !<br>Confirme ton compte en cliquant <a href='$url/confirmation/$user->id/$token->token/'>sur ce lien</a> ",
            $user->email
        );
        $m->send();
    }

    public static function userForgotPassword(User $user, Token $token) {
        $url = URL;
        $m = new Mailer(
            "Camagru - Mot de passe oublié ?",
            "Ouch, tu ne te souviens plus de ton mot de passe ?!<br>Change le en cliquant ici <a href='$url/changer-de-mot-de-passe/$user->id/$token->token/'>sur ce lien</a> ",
            $user->email
        );
        $m->send();
    }

    public static function userChangeMail($oldemail, $email) {
        $m = new Mailer(
            "Camagru - Changement de mail",
            "Une nouvelle adresse à été défini pour votre compte: $email.",
            $oldemail
        );
        $m->send();
        $m = new Mailer(
            "Camagru - Changement de mail",
            "Une nouvelle adresse à été défini. Votre ancienne adresse email était: $oldemail.",
            $email
        );
        $m->send();
    }

    public static function pictureNewComment($idpciture, $comment, $username, $mail) {
        $url = URL;
        $m = new Mailer(
            "Camagru - Nouveau commentaire sur une de vos photo",
            "Un commentaire sur <a href='$url/photo/$idpciture/'>cette photo</a> émanant de l'utilisateur $username.<br>Le commentaire est: \"$comment\".",
            $mail
        );
        $m->send();
    }
}
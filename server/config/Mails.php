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
}
<?php

class Messages
{
    public static function shouldEnsure($array) {
        $fm = new FlashMessage("", FlashType::$ERROR);
        foreach ($array as $key => $item) {
            $fm->message .= " · $key n'est pas rempli ou est vide.<br>";
        }
        $fm->register();
    }

    public static function emailShouldBeUnique() {
        $fm = new FlashMessage("L'email entré existe déjà.", FlashType::$ERROR);
        $fm->register();
    }

    public static function emailShouldExist() {
        $fm = new FlashMessage("L'email entré doit exister.", FlashType::$ERROR);
        $fm->register();
    }

    public static function emailShouldBeValid() {
        $fm = new FlashMessage("L'email entré n'est pas valide. <br>Exemple d'email: alexis@gmail.fr.", FlashType::$ERROR);
        $fm->register();
    }

    public static function usernameShouldBeUnique() {
        $fm = new FlashMessage("Le nom d'utilisateur entré existe déjà.", FlashType::$ERROR);
        $fm->register();
    }

    public static function usernameShouldExist() {
        $fm = new FlashMessage("Le nom d'utilisateur doit exister.", FlashType::$ERROR);
        $fm->register();
    }

    public static function usernameShouldBeValid() {
        $fm = new FlashMessage("Le nom d'utilisateur n'est pas valide. <br>Seulement miniscules/majuscules et chiffres sont autorisés.", FlashType::$ERROR);
        $fm->register();
    }

    public static function passwordShouldMatch() {
        $fm = new FlashMessage("Les mots de passes ne correspondent pas.", FlashType::$ERROR);
        $fm->register();
    }

    public static function passwordShouldHaveComplexity() {
        $fm = new FlashMessage("Le mot de passe doit contenir au moins une majuscule, un chiffre et doit faire au minimum 6 caractères.", FlashType::$ERROR);
        $fm->register();
    }

    public static function loginFail() {
        $fm = new FlashMessage("Combinaison email mot de passe incorrecte.", FlashType::$ERROR);
        $fm->register();
    }

    public static function successRegistration()
    {
        $fm = new FlashMessage("Vous venez de vous inscrire! Regardez vos mails pour valider votre compte", FlashType::$SUCCESS);
        $fm->register();
    }

    public static function successPwdReset()
    {
        $fm = new FlashMessage("Un email pour réinitialisé votre mot de passe a été envoyé!", FlashType::$SUCCESS);
        $fm->register();
    }

    public static function successAccountConfirmed()
    {
        $fm = new FlashMessage("Votre compte est validé, vous pouvez vous connecter!", FlashType::$SUCCESS);
        $fm->register();
    }

    public static function successPasswordChanged()
    {
        $fm = new FlashMessage("Votre mot de passe a été changé vous pouvez maintenant vous connecter!", FlashType::$SUCCESS);
        $fm->register();
    }

    public static function badEntity()
    {
        $fm = new FlashMessage("Hum qui es-tu ?", FlashType::$ERROR);
        $fm->register();
    }

    public static function pictureUploadInvalid()
    {
        $fm = new FlashMessage("Image invalide.", FlashType::$ERROR);
        $fm->register();
    }

    public static function pictureUploadNoFileSent()
    {
        $fm = new FlashMessage("Aucun fichier reçu.", FlashType::$ERROR);
        $fm->register();
    }

    public static function pictureUploadErrSize()
    {
        $fm = new FlashMessage("La taille du fichier est supérieur à 1 MO.", FlashType::$ERROR);
        $fm->register();
    }

    public static function pictureUploadErrType()
    {
        $fm = new FlashMessage("Le type du fichier est invalide. (authorisé: jpeg et png)", FlashType::$ERROR);
        $fm->register();
    }

    public static function pictureUploadInvalidSize()
    {
        $fm = new FlashMessage("La taille du fichier est invalide.", FlashType::$ERROR);
        $fm->register();
    }

    public static function pictureUploadError()
    {
        $fm = new FlashMessage("Erreur survenue lors du traitement du fichier.", FlashType::$ERROR);
        $fm->register();
    }

    public static function pictureUploadSuccess()
    {
        $fm = new FlashMessage("La photo a bien été créée.", FlashType::$SUCCESS);
        $fm->register();
    }

    public static function pictureCommentLength() {
        $fm = new FlashMessage("La longueur du commentaire est invalide. Max 1000 caractères.", FlashType::$ERROR);
        $fm->register();
    }

    public static function pictureCommentSuccess() {
        $fm = new FlashMessage("Votre commentaire a été posté !", FlashType::$SUCCESS);
        $fm->register();
    }

    public static function pictureDeleted() {
        $fm = new FlashMessage("La photo a été supprimé !", FlashType::$SUCCESS);
        $fm->register();
    }

    public static function settingsPwdMissingNew()
    {
        $fm = new FlashMessage("Le nouveau mot de passe est requis pour le changer.", FlashType::$ERROR);
        $fm->register();
    }

    public static function settingsPwdMissingOld()
    {
        $fm = new FlashMessage("Le mot de passe actuel est requis pour le changer.", FlashType::$ERROR);
        $fm->register();
    }

    public static function settingsPwdOldBad()
    {
        $fm = new FlashMessage("Votre mot de passe actuel est erroné.", FlashType::$ERROR);
        $fm->register();
    }

    public static function settingsChanged($changed)
    {
        $msg = "Ces préférences ont été changés:<br>";
        foreach ($changed as $change) {
            if ($change == UserSettings::$CHANGED_USERNAME) {
                $msg .= "- Votre nom d'utilisateur<br>";
            }
            if ($change == UserSettings::$CHANGED_EMAIL) {
                $msg .= "- Votre adresse email<br>";
            }
            if ($change == UserSettings::$CHANGED_NOTIFY) {
                $msg .= "- Vos préférence de notifications<br>";
            }
            if ($change == UserSettings::$CHANGED_PASSWORD) {
                $msg .= "- Votre mot de passe<br>";
            }
        }
        $fm = new FlashMessage($msg, FlashType::$SUCCESS);
        $fm->register();
    }
}
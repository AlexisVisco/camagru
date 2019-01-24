<?php


class UserController extends BaseController
{

    public function register()
    {
        if (isset($_SESSION["user"])) $this->redirect("/");
        if (count($_POST) != 0) $this->postRegister();
        echo self::render("register", ["fullheight" => "is-fullheight"]);
    }

    public function forgotPwd()
    {
        if (isset($_SESSION["user"])) $this->redirect("/");
        if (count($_POST) != 0) $this->postForgotPwd();
        echo self::render("forgot_password", ["fullheight" => "is-fullheight"]);
    }

    public function changePwd($id, $token)
    {
        if (isset($_SESSION["user"])) $this->redirect("/");
        if (count($_POST) != 0) $this->postChangePwd($id, $token);
        echo self::render("change_password", ["fullheight" => "is-fullheight"]);
    }

    public function login()
    {
        if (isset($_SESSION["user"])) $this->redirect("/");
        if (count($_POST) != 0) $this->postLogin();
        echo self::render("login", ["fullheight" => "is-fullheight"]);
    }

    public function settings()
    {
        if (count($_POST) != 0) $this->postSettings();
        echo self::render("settings", ["fullheight" => "is-fullheight"]);
    }

    public function logout()
    {
        User::logout();
        $this->redirect("/");
    }


    public function confirm($id, $token)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = new User();
            $user = $user->load($id);

            $tok = new Token();
            $tok = $tok->loadWhereWithType("token", $token, Token::$TYPE_CONFIRM);

            if (($user == NULL || $tok == NULL) || $tok->id != $user->id) {
                $this->redirect("/");
                return;
            }
            if ($user->confirmed == 0) {
                $user->confirmed = 1;
                $tok->delete();
                Messages::successAccountConfirmed();
                $user->update();
                $this->redirect("/" . Routes::$USER_LOGIN);
                return;
            }
            $this->redirect("/");
        } else {
            echo self::render("verif_account", ["fullheight" => "is-fullheight", "id" => $id, "token" => $token]);
        }
    }

    private function postRegister()
    {
        $ensure = $this->ensure(["email", "username", "password", "passwordConfirm"]);
        if (count($ensure) != 0) Messages::shouldEnsure($ensure);
        else {
            $ur = new UserRegister($_POST);
            if ($ur->validate()) {
                $user = new User();
                $token = new Token();

                $user->init($ur->username, $ur->email, $ur->password)->save();

                $token->init($user->id, Token::$TYPE_CONFIRM)->save();

                Messages::successRegistration();
                Mails::userConfirmation($user, $token);
                $this->redirect("/" . Routes::$USER_LOGIN);
                exit(0);
            }
        }
    }

    private function postLogin()
    {
        $ensure = $this->ensure(["email", "password"]);
        if (count($ensure) != 0) Messages::shouldEnsure($ensure);
        else {
            $ul = new UserLogin($_POST);
            if ($ul->validate()) {
                $u = new User();
                $u = $u->loadWhere("email", $ul->email);
                $u->login();
                $this->redirect("/");
                exit(0);
            }
        }
    }

    private function postForgotPwd()
    {
        $ensure = $this->ensure(["email"]);
        if (count($ensure) != 0) Messages::shouldEnsure($ensure);
        else {
            $ufp = new UserForgotPassword($_POST);
            if ($ufp->validate()) {

                $user = new User();
                $user = $user->loadWhere("email", $ufp->email);

                if ($user != null) {
                    $token = new Token();
                    $token->init($user->id, Token::$TYPE_FORGOT_PWD)->save();
                    Mails::userForgotPassword($user, $token);
                }

                Messages::successPwdReset();
                $this->redirect("/" . Routes::$USER_LOGIN);
                exit(0);
            }
        }
    }

    private function postChangePwd($id, $token)
    {
        $ensure = $this->ensure(["password", "passwordConfirm"]);
        if (count($ensure) != 0) Messages::shouldEnsure($ensure);
        else {
            $ucp = new UserChangePassword($id, $token, $_POST);
            if ($ucp->validate()) {
                /** @var User $user */
                $user = new User();
                $user = $user->load($id);
                $user->setPassword($ucp->password);
                $user->updateWithPassword();

                $tok = new Token();
                $tok->loadWhereWithType("token", $token, Token::$TYPE_FORGOT_PWD)->delete();

                Messages::successPasswordChanged();
                $this->redirect("/" . Routes::$USER_LOGIN);
                exit(0);
            }
        }
    }

    private function postSettings()
    {
        $ensure = $this->ensure(["email", "username"]);
        if (count($ensure) != 0) Messages::shouldEnsure($ensure);
        else {
            $us = new UserSettings($_POST);
            if ($us->validate() && count($us->getChanged()) > 0) {
                $user = new User();
                $u = json_decode($_SESSION["user"]);
                $user = $user->load($u->id);
                /** @var User $user */
                $user->load($u->id);
                $oldmail = $user->email;
                $user->email = $us->email;
                $user->username = $us->username;
                $user->notified = $us->notify;
                if ($us->changePassword()) {
                    $user->setPassword($us->passwordNew);
                    $user->updateWithPassword();
                } else
                    $user->update();
                $user->login();
                if (in_array(UserSettings::$CHANGED_EMAIL, $us->getChanged())) {
                    Mails::userChangeMail($oldmail, $user->email);
                }
                Messages::settingsChanged($us->getChanged());
            }
        }
    }
}
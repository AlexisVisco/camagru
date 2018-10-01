<?php


class UserController extends BaseController
{

    public function register()
    {
        if (count($_POST) != 0) $this->postRegister();
        echo self::render("register");
    }

    public function forgotPwd()
    {
        if (count($_POST) != 0) $this->postForgotPwd();
        echo self::render("forgot_password");
    }

    public function changePwd($id, $token)
    {
        echo self::render("change_password");
    }

    public function login()
    {
        if (count($_POST) != 0) $this->postLogin();
        echo self::render("login");
    }

    public function logout()
    {
        User::logout();
        $this->redirect("/");
    }

    private function postRegister()
    {
        $ensure = $this->ensure(["email", "username", "password", "passwordConfirm"]);
        if (count($ensure) != 0) Messages::shouldEnsure($ensure);
        else {
            $ur = new UserRegister($_POST);
            if ($ur->validate()) {
                $user = new User();
                $user->init(
                    $ur->username, $ur->email,
                    password_hash(SALT . $ur->password, PASSWORD_DEFAULT)
                );
                $user->save();
                $fm = new FlashMessage("Vous venez de vous inscrire! Regardez vos mails pour valider votre compte", FlashType::$SUCCESS);
                $fm->register();
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

    public function confirm($id, $token)
    {
        $user = new User();
        $user = $user->load($id);
        if ($user == NULL) {
            $this->redirect("/");
            return ;
        }
        if ($user->confirmed == 0 && $user->token == $token) {
            $user->confirmed = 1;
            $user->token = "";
            $fm = new FlashMessage("Votre compte est validé, vous pouvez vous connecter!", FlashType::$SUCCESS);
            $fm->register();
            $user->update();
            $this->redirect("/" . Routes::$USER_LOGIN);
            return;
        }
        $this->redirect("/");
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
                $user->token = $user->newToken();
                $fm = new FlashMessage("Un email pour réinitialisé votre mot de passe a été envoyé!", FlashType::$SUCCESS);
                $fm->register();
                $user->update();
                $this->redirect("/" . Routes::$USER_LOGIN);
                //todo send email
                exit(0);
            }
        }

    }
}
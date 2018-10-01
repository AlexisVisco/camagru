<?php


class UserController extends BaseController
{

    public function register()
    {
        if (count($_POST) != 0) $this->postRegister();
        echo self::render("register");
    }

    private function postRegister() {
        $ensure = $this->ensure(["email", "username", "password", "passwordConfirm"]);
        if (count($ensure) != 0) Errors::shouldEnsure($ensure);
        else {
            $ur = new UserRegister($_POST);
            if ($ur->validate()){
                $user = new User();
                $user->init(
                    $ur->username,
                    $ur->email,
                    password_hash(SALT . $ur->password, PASSWORD_DEFAULT)
                );
                $user->save();

                $fm = new FlashMessage("Vous venez de vous inscrire! Regardez vos mails pour confirmer votre compte", FlashType::$SUCCESS);
                $fm->register();
                $this->redirect("/".Routes::$USER_LOGIN);
                exit(0);
            }
        }
    }

    public function forgotPwd()
    {
        echo self::render("forgot_password");
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
        //exit(0);
    }

    private function postLogin()
    {
        $ensure = $this->ensure(["email", "password"]);
        if (count($ensure) != 0) Errors::shouldEnsure($ensure);
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
}
<?php


class UserController extends BaseController
{

    public function register()
    {
        if (count($_POST) != 0) $this->postRegister();
        echo self::render("register", ["fullheight" => "is-fullheight"]);
    }

    public function forgotPwd()
    {
        if (count($_POST) != 0) $this->postForgotPwd();
        echo self::render("forgot_password", ["fullheight" => "is-fullheight"]);
    }

    public function changePwd($id, $token)
    {
        if (count($_POST) != 0) $this->postChangePwd($id, $token);
        echo self::render("change_password", ["fullheight" => "is-fullheight"]);
    }

    public function login()
    {
        if (count($_POST) != 0) $this->postLogin();
        echo self::render("login", ["fullheight" => "is-fullheight"]);
    }

    public function settings()
    {
        echo self::render("settings", ["fullheight" => "is-fullheight"]);
    }

    public function logout()
    {
        User::logout();
        $this->redirect("/");
    }



    public function confirm($id, $token)
    {
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
                $user = new User();
                $user = $user->load($id);
                $user->setPassword($ucp->password);
                $user->update();

                $tok = new Token();
                $tok->loadWhereWithType("token", $token, Token::$TYPE_FORGOT_PWD)->delete();

                Messages::successPasswordChanged();
                $this->redirect("/" . Routes::$USER_LOGIN);
                exit(0);
            }
        }
    }
}
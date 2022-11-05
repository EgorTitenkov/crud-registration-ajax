<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $user = new LoginUser($_POST['login'], $_POST['password']);
    }
}

class LoginUser
{
    private $login;
    private $password;
    private $storage = "data.json";
    private $stored_users;
    private $message;
    private $username;


    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
        $this->stored_users = json_decode(file_get_contents($this->storage), true);
        $this->username = $this->findNameOfUserInJSON();
        $this->login();
    }

    private function login()
    {
        foreach ($this->stored_users as $user) {
            if ($user['login'] == $this->login) {
                if (password_verify($this->password, $user['password'])) {
                    $this->message = "Success";

                    echo $this->message;

                    session_start();

                    $_SESSION['user'] = $this->login;

                    setcookie("login_cookie", $this->findNameOfUserInJSON());

                    break;
                }
            }
        }

        unset($this->stored_users[$user['login']]);

        if ($this->message != 'Success') {
            $this->message = 'Invalid login or password!';
            echo $this->message;
        }
    }

    private function findNameOfUserInJSON()
    {
        foreach ($this->stored_users as $user) {
            if ($user['login'] == $this->login) {
                session_start();
                $_SESSION['username'] = $user['name'];
                return $user['username'];
            }
        }
    }

}


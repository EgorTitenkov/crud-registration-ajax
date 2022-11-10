<?php
error_reporting(0);
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
    private $response;
    private $username;


    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
        $this->stored_users = json_decode(file_get_contents($this->storage), true);
        $this->username = $this->findNameOfUserInJSON();
        $this->login();

        $this->response = [
            "login" => $this->login,
            "password" => $this->password,
            "message" => $this->message
        ];

        echo json_encode($this->response);
    }

    private function login()
    {
        foreach ($this->stored_users as $user) {
            if ($user['login'] == $this->login) {
                if (password_verify($this->password, $user['password'])) {
                    $this->message = "Success";

                    session_start();

                    $_SESSION['user'] = $this->login;

                    setcookie("login_cookie", $this->findNameOfUserInJSON(), time() + 86400);

                    break;
                }
            }
        }

        unset($this->stored_users[$user['login']]);

        if ($this->message != 'Success') {
            $this->message = 'Invalid login or password!';
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


<?php
if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirmation_password']) && isset($_POST['email']) && isset($_POST['name']))
{
    $user = new CreateUser($_POST['login'], $_POST['password'], $_POST['confirmation_password'], $_POST['email'], $_POST['name']);

}
?>

<?php

class CreateUser
{

    private $login;
    private $raw_password;
    private $confirmation_password;
    private $email;
    private $name;
    private $encrypted_password;
    private $storage = "data.json";
    private $stored_users;
    private $new_user;
    private $message;
    private $success;

    public function __construct($login, $password, $confirmation_password, $email, $name)
    {
        $this->login = filter_var($login, FILTER_UNSAFE_RAW);

        $this->raw_password = filter_var(trim($password), FILTER_UNSAFE_RAW);

        $this->confirmation_password = filter_var(trim($confirmation_password), FILTER_UNSAFE_RAW);

        $this->encrypted_password = password_hash($this->raw_password, PASSWORD_DEFAULT);

        $this->email = filter_var($email, FILTER_VALIDATE_EMAIL);

        $this->name = filter_var($name, FILTER_UNSAFE_RAW);

        $this->stored_users = json_decode(file_get_contents($this->storage), true);

        $this->new_user = [
            "login" => $this->login,
            "password" => $this->encrypted_password,
            "email" => $this->email,
            "name" => $this->name,
        ];

        $this->insertUser();
    }

    private function checkLoginOrEmailExists()
    {

        foreach ($this->stored_users as $user) {
            if ($_POST['login'] == $user['login']) {
                $this->message = "This login already exists";
                echo  $this->message;
                $is_exists = true;
                break;

            } elseif ($_POST['email'] == $user['email']) {
                $this->message = "This email already exists";
                echo $this->message;
                $is_exists = true;
                break;

            } else {
                $this->message = "User was successfully created";
                $is_exists = false;
            }
        }

        echo $this->message;

        unset($this->stored_users[$user['login']]);

        return $is_exists;
    }

    private function insertUser()
    {
        if (empty($this->stored_users)) {
            $this->stored_users[] = $this->new_user;
            file_put_contents('data.json', json_encode($this->stored_users, JSON_PRETTY_PRINT));
        }

        if (!$this->checkLoginOrEmailExists()) {
            $this->stored_users[] = $this->new_user;
            file_put_contents('data.json', json_encode($this->stored_users, JSON_PRETTY_PRINT));
        }
    }
}

?>

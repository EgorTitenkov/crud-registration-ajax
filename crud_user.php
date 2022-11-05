<?php

if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

    if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirmation_password']) && isset($_POST['email']) && isset($_POST['name'])) {
        $user = new CreateUser($_POST['login'], $_POST['password'], $_POST['confirmation_password'], $_POST['email'], $_POST['name']);
    }
}


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
    private $status;

    public function __construct($login, $password, $confirmation_password, $email, $name)
    {
        $this->login = filter_var($login, FILTER_UNSAFE_RAW);

        $this->raw_password = filter_var(trim($password), FILTER_UNSAFE_RAW);

        $this->confirmation_password = filter_var(trim($confirmation_password), FILTER_UNSAFE_RAW);

        $this->encrypted_password = password_hash($this->raw_password, PASSWORD_DEFAULT);

        $this->email = filter_var($email, FILTER_VALIDATE_EMAIL);

        $this->name = trim(filter_var($name, FILTER_UNSAFE_RAW));

        $this->stored_users = json_decode(file_get_contents($this->storage), true);

        $this->new_user = [
            "login" => $this->login,
            "password" => $this->encrypted_password,
            "email" => $this->email,
            "name" => $this->name,
        ];

        //$this->updateUserByLogin($this->>login);
        //$this->deleteUserByLogin($this->login);
        $this->insertUser();
    }

    private function checkLoginOrEmailExists()
    {

        foreach ($this->stored_users as $user) {
            if ($this->login == $user['login']) {
                $this->message = "This login already exists";
                $this->status = 'errorLogin';
                $is_user_exists = true;
                break;

            } elseif ($this->email == $user['email']) {
                $this->message = "This email already exists";
                $this->status = 'errorEmail';
                $is_user_exists = true;
                break;

            } else {
                $is_user_exists = false;
                $this->status = 'success';
                $this->message = "User was successfully created";

            }
        }

        $this->sendMessageResponse();

        unset($this->stored_users[$user['login']]);

        return $is_user_exists;
    }

    private function isStorageEmpty() {
        if (empty($this->stored_users)) {
            return true;
        } else {
            return false;
        }
    }

    private function insertUser()
    {
        if (!$this->checkLoginOrEmailExists() && !$this->isStorageEmpty()) {
            $this->stored_users[] = $this->new_user;
            file_put_contents('data.json', json_encode($this->stored_users, JSON_PRETTY_PRINT));
        } elseif ($this->isStorageEmpty()){
            $this->stored_users[] = $this->new_user;
            $this->status = 'success';
            file_put_contents('data.json', json_encode($this->stored_users, JSON_PRETTY_PRINT));
            $this->sendMessageResponse();
        }
    }

    private function sendMessageResponse()
    {
        if ($this->status == 'errorLogin') {
            echo json_encode($this->message);
        } elseif ($this->status == 'errorEmail') {
            echo json_encode($this->message);
        } elseif ($this->status == 'success') {
            echo json_encode($this->message);
        }
    }

    private function deleteUserByLogin($deleted_user_login)
    {
        foreach ($this->stored_users as $user => $login) {
            if ($deleted_user_login == $login['login']) {
                unset($this->stored_users[$user]);
                file_put_contents('data.json', json_encode($this->stored_users, JSON_PRETTY_PRINT));
                echo $this->message = "User was successfully deleted!";
            }
        }
    }

    private function updateUserByLogin($deleted_user_login)
    {
        foreach ($this->stored_users as $user => $login) {
            if ($deleted_user_login == $login['login']) {

                $this->stored_users[$user]['login'] = $this->login;
                $this->stored_users[$user]['password'] = $this->encrypted_password;
                $this->stored_users[$user]['email'] = $this->email;
                $this->stored_users[$user]['name'] = $this->name;

                file_put_contents('data.json', json_encode($this->stored_users, JSON_PRETTY_PRINT));
                echo $this->message = "User was successfully updated!";
            }
        }
    }
}

?>

<?php

class RegisterUser {
    private $login;
    private $raw_password;
    private $confirmation_password;
    private $email;
    private $name;
    private $encrypted_password;
    public $error;
    public $success;
    private $storage = "data.json";
    private $stored_users;
    private $new_user;


    public function __construct($login, $password, $confirmation_password, $email, $name){
        $this->login=trim($this->login);
        $this->login = filter_var($login, FILTER_UNSAFE_RAW);

        $this->raw_password = filter_var(trim($password), FILTER_UNSAFE_RAW);

        $this->confirmation_password = filter_var(trim($confirmation_password), FILTER_UNSAFE_RAW);

        $this->encrypted_password = password_hash($this->raw_password, PASSWORD_DEFAULT);

        $this->email = filter_var($email, FILTER_VALIDATE_EMAIL);

        $this->name = filter_var($name,FILTER_UNSAFE_RAW);

        $this->stored_users = json_decode(file_get_contents($this->storage), true);

        $this->new_user = [
            "login" => $this->login,
            "password" => $this->encrypted_password,
            "email" => $this->email,
            "name" => $this->name,
        ];

        $this->insertUser();
    }



    private function loginOrEmailExists(){
        foreach ($this->stored_users as $user){
            if ($this->login == $user['login']){
                $this->error = "Username already taken, please choose a different one";
                return true;
            }
            elseif ($this->email == $user['email']){
                $this->error = "An account has already been created at this email address";
                return true;
            }else{
                return false;
            }
        }
    }

    private function insertUser(){
        if (!$this->loginOrEmailExists()){
            $this->stored_users[] = $this->new_user;
            if (file_put_contents($this->storage, json_encode($this->stored_users, JSON_PRETTY_PRINT))){
                return$this->success = "Your registration was successful";
            } else{
                return $this->error = "Something went wrong, please try again";
            }
        }
    }
}

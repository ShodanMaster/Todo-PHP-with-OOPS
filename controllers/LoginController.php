<?php

require_once("../models/User.php");

class LoginController extends User{
    private $username;
    private $password;

    // public function __construct($username, $password){  
    //     $this->username = $username;
    //     $this->password = $password;
    // }

    public function authenticate($username, $password) {
        $authenticated = $this->authenticated($username, $password);
        // print_r( $authenticated);

        if ($authenticated['status'] === 200) {
            return json_encode([
                'status' => 200,
                'message' => 'Logged In',
                'url' => 'index.php'
            ]);
        } else {
            return json_encode($authenticated);
        }
        return json_encode($authenticated);
    }    

    public function register($username, $password) {
        $registered = $this->registered($username, $password);
        return json_encode($registered);
    }

    public function validate($username, $password, $confirmPasswrod = null) {

    }
    
}
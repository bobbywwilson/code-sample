<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");

class ValidateCreateUser {
    private $validation;
    private $validations;
    private $errors;

    public function __construct() {
        $this->validation = new Validation();
    }

    public function __destruct() {
        unset($this->validation);
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

    /**
     * Performs validation on create user
     * 
     * @param Array $fields
     * @return Array $validations
    */
    private function validateCreateUser($fields) {
        $role = $this->validation->clean_txt($fields["role"]);
        $username = $this->validation->clean_txt($fields["username"]);
        $first_name = $this->validation->clean_txt($fields["first-name"], "T");
        $last_name = $this->validation->clean_txt($fields["last-name"], "T");
        $email = $this->validation->clean_email($fields["email"]);
        $confirm_email = $this->validation->clean_email($fields["confirm-email"]);
        $password = $this->validation->clean_txt($fields["password"]);
        $confirm_password = $this->validation->clean_txt($fields["confirm-password"]);

        $this->validations[] = $this->validation->required($role, "Role");
        $this->validations[] = $this->validation->required($username, "Username");
        $this->validations[] = $this->validation->required($first_name, "First Name", "T");
        $this->validations[] = $this->validation->required($last_name, "Last Name", "T");
        $this->validations[] = $this->validation->required($email, "Email");
        $this->validations[] = $this->validation->required($confirm_email, "Confirm Email");
        $this->validations[] = $this->validation->required($password, "Password");
        $this->validations[] = $this->validation->required($confirm_password, "Confirm Password");

        $this->validations[] = $this->validation->valid_email($email, "Email");
        $this->validations[] = $this->validation->valid_email($confirm_email, "Confirm Email");

        foreach($this->validations as $rule) {
            if($rule != "") {
                $this->errors[] = $rule;
            }
        }

        if(isset($this->errors) && count($this->errors) > 0) {
            return ["errors" => $this->errors];
        } else {
            $fields = [
                "role" => $role,
                "username" => $username,
                "first-name" => $first_name,
                "last-name" => $last_name,
                "email" => $email,
                "password" => $password
            ];

            return $fields;
        }
    }

    /**
     * Public Validate Create User Interface
     * 
     * @param Array $fields
     * @return Array $validations
    */
    public function validate_create_user($fields) {
        return $this->validateCreateUser($fields);
    }
}
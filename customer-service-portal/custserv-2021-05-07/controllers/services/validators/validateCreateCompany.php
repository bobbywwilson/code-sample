<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");

class ValidateCreateCompany {
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
    private function validateCreateCompany($fields) {
        $company_name = $this->validation->clean_txt($fields["company-name"]);
        $company_contact = $this->validation->clean_txt($fields["company-contact"]);
        $contact_phone = $this->validation->clean_txt($fields["contact-phone"]);
        $contact_email = $this->validation->clean_email($fields["contact-email"]);
        $confirm_contact_email = $this->validation->clean_email($fields["confirm-contact-email"]);

        $this->validations[] = $this->validation->required($company_name, "Company Name", "T");
        $this->validations[] = $this->validation->required($company_contact, "Company Contact", "T");
        $this->validations[] = $this->validation->required($contact_phone, "Contact Phone");
        $this->validations[] = $this->validation->required($contact_email, "Contact Email");
        $this->validations[] = $this->validation->required($confirm_contact_email, "Confirm Contact Email");

        $this->validations[] = $this->validation->valid_email($contact_email, "Contact Email");
        $this->validations[] = $this->validation->valid_email($confirm_contact_email, "Confirm Contact Email");

        foreach($this->validations as $rule) {
            if($rule != "") {
                $this->errors[] = $rule;
            }
        }

        if(isset($this->errors) && count($this->errors) > 0) {
            return ["errors" => $this->errors];
        } else {
            $fields = [
                "company-name" => $company_name,
                "company-contact" => $company_contact,
                "contact-phone" => $contact_phone,
                "contact-email" => $contact_email,
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
    public function validate_create_company($fields) {
        return $this->validateCreateCompany($fields);
    }
}
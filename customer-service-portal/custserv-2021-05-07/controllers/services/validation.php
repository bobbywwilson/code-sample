<?php

    class Validation {
        public function clean_txt($text, $case = "") {
            $text = trim($text);
            $text = filter_var($text, FILTER_SANITIZE_STRING);
            
            switch($case) {
                case "L":
                    $text = strtolower($text);
                    break;
                case "U":
                    $text = strtoupper($text);
                    break;
                case "T":
                    $text = ucwords($text);
                    break;
            }
            
            return $text;
        }
            
        public function clean_email($email) {
            $email = $this->clean_txt($email, "L");
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            
            return $email;
        }

        public function clean_int($int) {
            $int = trim($int);
            $int = filter_var($int, FILTER_SANITIZE_NUMBER_INT);
            
            return $int;
        }

        public function required($var, $field_name) {
            if(strlen($var) == 0 || $var == "Select One") {
                return $field_name . " is required.";
            }
        }

        public function valid_email($email, $field_name) {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != "") {
                return $field_name . " must be a valid email.";
            }
        }

        public function max_length($var, $max_length = 8, $field_name) {
            if(strlen($var) > $max_length) {
                return $field_name . " exceeds maximum number of characters.";
            }
        }

        public function isEqual($var_1, $var_2, $field_name_1, $field_name_2) {
            if(strlen($var_1) > 0 && strlen($var_2) > 0 && strcmp($var_1, $var_2)) {
                return $field_name_1 . " does not match " . $field_name_2 . ".";
            }
        }
    }
?>

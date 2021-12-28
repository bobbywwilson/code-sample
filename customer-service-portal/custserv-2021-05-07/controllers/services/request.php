<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
	
	class Request {
		/**
         * Capture GET and POST Request Fields
         * 
         * @param String $key
         * @return String $value
        */
		private function getInput($key) {
			try {
                if (! isset($key)) {
                    exit('Please provide a key to retrieve value');
                }

                if (isset($_POST)) {
                    $request = $_POST;
                } else if (isset($_GET)) {
                    $request = $_GET;
                } else {
                    $request = [];
                }
                
                if (! empty($request[$key])) {
                    return $request[$key];
                } else {
                    $request = [];

                    return $request;
                }
            } catch (PDOException $exception) {	
                echo "Unable to compete request: " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Capture GET and POST Request Array
         * 
         * @return Request $request
        */
		private function getFields() {
			try {
                if (isset($_POST)) {
                    $request = $_POST;
                } else if (isset($_GET)) {
                    $request = $_GET;
                } else {
                    $request = [];
                }
                
                if (! empty($request)) {
                    return $request;
                } else {
                    $request = [];

                    return $request;
                }
            } catch (PDOException $exception) {	
                echo "Unable to compete request: " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Public Request Fields Interface
         * 
         * @param String $key
         * @return String $value
        */
        public function input($key) {
            return $this->getInput($key);
        }

        /**
         * Public Request Array Interface
         * 
         * @return Request $request
        */
        public function fields() {
            return $this->getFields();
        }
	}
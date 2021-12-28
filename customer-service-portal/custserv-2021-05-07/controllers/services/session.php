<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
	
	class Session {
        /**
         * Set Session Variable
         * 
         * @param String $key
         * @param Mixed $value
         * @return Void
        */
		private function setSession($key, $value) {
			try {
                if (! isset($key) || ! isset($value)) {
                    exit('Please provide a key and value to create session variable');
                }

                $_SESSION[strtolower($key)] = $value;
            } catch (PDOException $exception) {	
                echo "Unable to compete request: " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Get Session Variable
         * 
         * @param String $key
         * @return String $value
        */
		private function getSession($key) {
			try {
                if (! isset($key)) {
                    exit('Please provide a key to retrieve session variable');
                }

                $value = $_SESSION[strtolower($key)];

                return $value;
            } catch (PDOException $exception) {	
                echo "Unable to compete request: " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Delete Session Variable
         * 
         * @param String $key
         * @return Void
        */
		private function deleteSession($key) {
			try {
                if (! isset($key)) {
                    exit('Please provide a key to delete session variable');
                }

                unset($_SESSION[strtolower($key)]);
            } catch (PDOException $exception) {	
                echo "Unable to compete request: " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Check if Session Variable is set
         * 
         * @param String $key
         * @return Boolean $is_set
        */
		private function keyExists($key) {
			try {
                if (! isset($key)) {
                    exit('Please provide a key to retrieve session variable');
                }

                $is_set = isset($_SESSION[strtolower($key)]);

                return $is_set;
            } catch (PDOException $exception) {	
                echo "Unable to compete request: " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Public Set Session Interface
         * 
         * @param String $key
         * @param Mixed $value
         * @return Void
        */
        public function set_session($key, $value) {
            return $this->setSession($key, $value);
        }

        /**
         * Public Get Session Interface
         * 
         * @param String $key
         * @return String $value
        */
        public function get_session($key) {
            return $this->getSession($key);
        }

        /**
         * Public Delete Session Interface
         * 
         * @param String $key
         * @return Void
        */
        public function delete_session($key) {
            return $this->deleteSession($key);
        }

        /**
         * Public Check Session Set Interface
         * 
         * @param String $key
         * @return Boolean $is_set
        */
        public function key_exists($key) {
            return $this->keyExists($key);
        }
	}
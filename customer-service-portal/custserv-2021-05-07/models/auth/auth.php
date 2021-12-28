<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
	
	class Auth {
		private $conn = "";
		
		public function __construct() {
			$db = new Database();
			$this->conn = $db->conn;
		}

		public function __destruct() {
			$this->conn = null;
		}
		
		public function __get($name) {
			return $this->$name;
		}
		
        public function __set($name, $value) {
			$this->$name = $value;
		}

        /**
         * Generate Base64 Url Encoded String
         * 
         * PHP has no base64UrlEncode function, so let's define one that
         * does some magic by replacing + with -, / with _ and = with ''.
         * This way we can pass the string within URLs without any URL encoding.
         * 
         * @param String $string
         * @return String $string
        */
        private function base64UrlEncode($string) {
            return str_replace(
                ['+', '/', '='],
                ['-', '_', ''],
                base64_encode($string)
            );
        }

        /**
         * Decode Authorization Token
         * 
         * @param String $token
         * @return Array $decode_payload
        */
		private function decodeToken($token) {
			try {
                if (! isset($token)) {
                    exit('Please provide a token to decode');
                }

                $token_parts = explode('.', $token);
                $payload = base64_decode($token_parts[1]);

                $decode_payload = json_decode($payload, true);

                return $decode_payload;
            } catch (PDOException $exception) {	
                echo "Unable to compete request: " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Retrieve user from the database
         * 
         * @param Array $fields
         * @return User $user
        */
		private function authenticateUser($fields) {
			try {
                $user = "
                    SELECT 
                        CUST.id,
                        CUST.username,
                        RO.description as role,
                        CUST.first_name,
                        CUST.last_name,
                        CUST.password,
                        CUST.email,
                        CUST.last_login
                    FROM 
                        users CUST
                    JOIN roles RO
                    ON CUST.role_id = RO.id
                    WHERE CUST.username = :username
                ";
            
                $user = $this->conn->prepare($user);
                $user->bindValue(':username', $fields['username'], PDO::PARAM_STR);

                $user->execute();

                $user = $user->fetchAll(PDO::FETCH_ASSOC);

                if (count($user) > 0) {
                    if (password_verify($fields['password'], $user[0]['password'])) {
                        unset($user[0]['password']);
    
                        return $user;
                    } else {
                        $user = [];
    
                        return $user;
                    }
                }
                
                $user = [];
    
                return $user; 
            } catch (PDOException $exception) {	
                echo "Unable to retrieve record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Generate Authorization Token
         * 
         * @param Array $fields
         * @return Array $token
        */
		private function getToken($fields) {
			try {
                $header = json_encode([
                    'typ' => 'String',
                    'alg' => 'HS256'
                ]);

                $payload = json_encode([
                    'user_id' => $fields[0]['id'],
                    'role' => $fields[0]['role'],
                    'iat' => strtotime('now')
                ]);

                $header = $this->base64UrlEncode($header);
                $payload = $this->base64UrlEncode($payload);

                $signature = hash_hmac('sha256', $header . "." . $payload, getenv('SECRET'), true);
                
                $signature = $this->base64UrlEncode($signature);

                $token = $header . "." . $payload . "." . $signature;

                return $token;
            } catch (PDOException $exception) {	
                echo "Unable to compete request: " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Validate Authorization Token
         * 
         * @param String $token
         * @return Boolean $valid
        */
		private function validToken($token) {
			try {
                if (! isset($token)) {
                    exit('Please provide a key to verify');
                }

                $token_parts = explode('.', $token);
                $header = base64_decode($token_parts[0]);
                $payload = base64_decode($token_parts[1]);
                $signature_provided = $token_parts[2];

                $decode_payload = $this->decodeToken($token);

                $expiration = date('Y-m-d H:i:a', ($decode_payload['iat'] + 60 * 60));
                $current_time = date('Y-m-d H:i:a', (strtotime('now')));

                $token_valid = $expiration > $current_time;

                $header = $this->base64UrlEncode($header);
                $payload = $this->base64UrlEncode($payload);
                $signature = hash_hmac('sha256', $header . "." . $payload, getenv('SECRET'), true);
                $signature = $this->base64UrlEncode($signature);

                $signature_valid = ($signature === $signature_provided);

                if ($token_valid && $signature_valid) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $exception) {	
                echo "Unable to compete request: " . $exception->getMessage();
                    
                exit();
            }
		}

        /** 
         * Public Decode Token Interface
         * 
         * @param String $token
         * @return String $decode_payload
        */
        public function decode_token($token) {
            return $this->decodeToken($token);
        }

        /** 
         * Public Authenticate User Interface
         * 
         * @param Array $fields
         * @return User $user
        */
        public function authenticate_user($fields) {
            return $this->authenticateUser($fields);
        }

        /** 
         * Public Get Token Interface
         * 
         * @param Array $fields
         * @return Array $token
        */
        public function get_token($fields) {
            return $this->getToken($fields);
        }

        /** 
         * Public Valid Token Interface
         * 
         * @param String $token
         * @return Boolean $valid
        */
        public function valid_token($token) {
            return $this->validToken($token);
        }
	}
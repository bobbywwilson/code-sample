<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");

	class UserController {
        private $validation;
        private $validations;
        private $message;

        public function __construct() {
			$this->validation = new ValidateCreateUser();
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
         * Create user in the database
         * 
         * @param Array $fields
         * @return String $message
        */
		private function createUser($fields) {
			try {
                $this->validations = $this->validation->validate_create_user($fields);

                if (isset($this->validations['errors']) && count($this->validations['errors']) > 0) {
                    return $this->validations;
                }
                
                $user_fields = [
                    "role_id" => $this->validations["role"],
                    "username" => $this->validations["username"],
                    "first_name" => $this->validations["first-name"],
                    "last_name" => $this->validations["last-name"],
                    "password" => $this->validations["password"],
                    "email" => $this->validations["email"]
                ];
                
                $user = new User();

                $user->create_user($user_fields);

                unset($user);
                
                $this->message[] = "User has been created.";

                return ["success" => $this->message];
            } catch (PDOException $exception) {	
                echo "Unable to add record(s): " . $exception->getMessage();
                    
                $this->message[] = "User was not created.";

                return ["error-log" => $this->message];
            }
		}

        /**
         * Retrieve user from the database
         * 
         * @param String $id
         * @return Array $user
        */
		private function getUser($id) {
			try {
                $user = new User();

                $user = $user->get_user($id);

                return $user;
            } catch (PDOException $exception) {	
                echo "Unable to retrieve record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Retrieve all users from the database
         *
         * @return Array $users
        */
		private function getUsers() {
			try {
                $users = new User();

                $users = $users->get_users();

                return $users;
            } catch (PDOException $exception) {	
                echo "Unable to retrieve record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Update user in the database
         * 
         * @param Array $fields
         * @return Void
        */
		private function updateUser($fields) :void {
			try {

            } catch (PDOException $exception) {	
                echo "Unable to update record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Delete user from the database
         * 
         * @param String $id
         * @return String $message
        */
		private function deleteUser($id) {
			try {
                $users = new User();

                $users = $users->delete_user($id);

                $this->message[] = "User has been deleted.";

                return ["success" => $this->message];
            } catch (PDOException $exception) {	
                echo "Unable to delete record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /** 
         * Public Create User Interface
         * 
         * @param Array $fields
         * @return String $message
        */
        public function create_user($fields) {
            return $this->createUser($fields);
        }

        /** 
         * Public Retrieve User Interface
         * 
         * @param String $id
         * @return Array $user
        */
        public function get_user($id) {
            return $this->getUser($id);
        }

        /** 
         * Public Retrieve Users Interface
         * 
         * @return Array $users
        */
        public function get_users() {
            return $this->getUsers();
        }

        /** 
         * Public Update User Interface
         * 
         * @param Array $fields
         * @return Void
        */
        public function update_user($fields) :void {
            $this->updateUser($fields);
        }

        /** 
         * Public Delete User Interface
         * 
         * @param String $id
         * @return String $message
        */
        public function delete_user($id) {
            return $this->deleteUser($id);
        }
	}
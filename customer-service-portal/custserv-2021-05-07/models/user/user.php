<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
	
	class User {
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
         * Create user in the database
         * 
         * @param Request $request
         * @return Void
        */
		private function createUser($request) :void {
            $password = password_hash($request['password'], PASSWORD_DEFAULT);

			try {
                $user = "
                    INSERT INTO users (
                        role_id,
                        username,
                        first_name,
                        last_name,
                        password, 
                        email
                    ) VALUES (
                        :role_id,
                        :username,
                        :first_name,
                        :last_name,
                        :password, 
                        :email
                    )
                ";
            
                $user = $this->conn->prepare($user);
                $user->bindValue(':role_id', $request['role_id'], PDO::PARAM_STR);
                $user->bindValue(':username', $request['username'], PDO::PARAM_STR);
                $user->bindValue(':first_name', $request['first_name'], PDO::PARAM_STR);
                $user->bindValue(':last_name', $request['last_name'], PDO::PARAM_STR);
                $user->bindValue(':password', $password, PDO::PARAM_STR);
                $user->bindValue(':email', $request['email'], PDO::PARAM_STR);
                
                $user->execute();
            } catch (PDOException $exception) {	
                echo "Unable to add record(s): " . $exception->getMessage();
                    
                exit();
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
                $user = "
                    SELECT 
                        CUST.id,
                        CUST.username,
                        RO.description as role,
                        CUST.first_name,
                        CUST.last_name,
                        CUST.email,
                        CUST.last_login
                    FROM 
                        users CUST
                    JOIN roles RO
                    ON CUST.role_id = RO.id
                    WHERE CUST.id = :id
                ";
            
                $user = $this->conn->prepare($user);
                $user->bindValue(':id', $id, PDO::PARAM_STR);
                
                $user->execute();

                $user = $user->fetchAll(PDO::FETCH_ASSOC);

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
                $user = "
                    SELECT 
                        CUST.id,
                        CUST.username,
                        RO.description as role,
                        CUST.first_name,
                        CUST.last_name,
                        CUST.email,
                        CUST.last_login
                    FROM 
                        users CUST
                    JOIN roles RO
                    ON CUST.role_id = RO.id
                ";
            
                $users = $this->conn->prepare($user);
                
                $users->execute();

                $users = $users->fetchAll(PDO::FETCH_ASSOC);

                return $users;
            } catch (PDOException $exception) {	
                echo "Unable to retrieve record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Retrieve user by username from the database
         * 
         * @param String $username
         * @return Array $user
        */
		private function getUserByUsername($username) {
			try {
                $user = "
                    SELECT id FROM users
                    WHERE username = :username
                ";
            
                $user = $this->conn->prepare($user);
                $user->bindValue(':username', $username, PDO::PARAM_STR);
                
                $user->execute();

                $user = $user->fetchAll(PDO::FETCH_ASSOC);

                return $user;
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
                $user = "
                    UPDATE users
                    SET
                        role_id = :role_id,
                        username = :username,
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :email,
                        updated_date = GETDATE()
                    WHERE id = :id
                ";
            
                $user = $this->conn->prepare($user);
                $user->bindValue(':role_id', $fields['role_id'], PDO::PARAM_STR);
                $user->bindValue(':username', $fields['username'], PDO::PARAM_STR);
                $user->bindValue(':first_name', $fields['first_name'], PDO::PARAM_STR);
                $user->bindValue(':last_name', $fields['last_name'], PDO::PARAM_STR);
                $user->bindValue(':email', $fields['email'], PDO::PARAM_STR);
                $user->bindValue(':id', $fields['id'], PDO::PARAM_STR);

                $user->execute();
            } catch (PDOException $exception) {	
                echo "Unable to update record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Delete user from the database
         * 
         * @param String $id
         * @return Array $user
        */
		private function deleteUser($id) :void {
			try {
                $user = "
                    DELETE FROM users
                    WHERE id = :id
                ";
            
                $user = $this->conn->prepare($user);
                $user->bindValue(':id', $id, PDO::PARAM_STR);
                
                $user->execute();
            } catch (PDOException $exception) {	
                echo "Unable to delete record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /** 
         * Public Create User Interface
         * 
         * @param Array $fields
         * @return Void
        */
        public function create_user($request) :void {
            $this->createUser($request);
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
         * Public Retrieve User By Username Interface
         * 
         * @param String $username
         * @return Array $user
        */
        public function get_user_by_username($username) {
            return $this->getUserByUsername($username);
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
         * @return Void
        */
        public function delete_user($id) :void {
            $this->deleteUser($id);
        }
	}
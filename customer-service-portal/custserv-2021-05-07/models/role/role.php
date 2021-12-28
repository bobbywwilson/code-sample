<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
	
	class Role {
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
         * Stores a role in the database
         * 
         * @param $fields array
         * @return Void
        */
		private function createRole($fields) {
			try {
                $role = "
                    INSERT INTO roles (
                        description
                    ) VALUES (
                        :description
                    )
                ";
            
                $role = $this->conn->prepare($role);
                $role->bindValue(':description', $fields['description'], PDO::PARAM_STR);
                
                $role->execute();
            } catch (PDOException $exception) {	
                echo "Unable to add record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /** 
         * Public Create Role Interface
         *
        */
        public function create_role($fields) {
            $this->createRole($fields);
        }
	}
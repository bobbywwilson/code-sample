<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
	
	class Company {
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
         * Store a company in the database
         * 
         * @param Array $fields
         * @return Void
        */
		private function createCompany($fields) :void {
			try {
                $company = "
                    INSERT INTO companies (
                        company_name, 
                        company_contact,
                        contact_phone,
                        contact_email
                    ) VALUES (
                        :company_name, 
                        :company_contact,
                        :contact_phone,
                        :contact_email
                    )
                ";
            
                $company = $this->conn->prepare($company);
                $company->bindValue(':company_name', $fields['company_name'], PDO::PARAM_STR);
                $company->bindValue(':company_contact', $fields['company_contact'], PDO::PARAM_STR);
                $company->bindValue(':contact_phone', $fields['contact_phone'], PDO::PARAM_STR);
                $company->bindValue(':contact_email', $fields['contact_email'], PDO::PARAM_STR);
                
                $company->execute();
            } catch (PDOException $exception) {	
                echo "Unable to add record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Retrieve company from the database
         * 
         * @param String $id
         * @return Array $company
        */
		private function getCompany($id) {
			try {
                $company = "
                    SELECT * FROM companies
                    WHERE id = :id
                ";
            
                $company = $this->conn->prepare($company);
                $company->bindValue(':id', $id, PDO::PARAM_STR);
                
                $company->execute();

                $company = $company->fetchAll(PDO::FETCH_ASSOC);

                return $company;
            } catch (PDOException $exception) {	
                echo "Unable to retrieve record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Update company in the database
         * 
         * @param Array $fields
         * @return Void
        */
		private function updateCompany($fields) :void {
			try {
                $company = "
                    UPDATE companies
                    SET
                        company_name = :company_name, 
                        company_contact = :company_contact,
                        contact_phone = :contact_phone,
                        contact_email = :contact_email,
                        updated_date = GETDATE()
                    WHERE id = :id
                ";
            
                $company = $this->conn->prepare($company);
                $company->bindValue(':company_name', $fields['company_name'], PDO::PARAM_STR);
                $company->bindValue(':company_contact', $fields['company_contact'], PDO::PARAM_STR);
                $company->bindValue(':contact_phone', $fields['contact_phone'], PDO::PARAM_STR);
                $company->bindValue(':contact_email', $fields['contact_email'], PDO::PARAM_STR);
                $company->bindValue(':id', $fields['id'], PDO::PARAM_STR);

                $company->execute();
            } catch (PDOException $exception) {	
                echo "Unable to update record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Retrieve company by name from the database
         * 
         * @param String $id
         * @return Array $company
        */
		private function getCompanyByName($company_name) {
			try {
                $company = "
                    SELECT * FROM companies
                    WHERE company_name = :company_name
                ";
            
                $company = $this->conn->prepare($company_name);
                $company->bindValue(':company_name', $company_name, PDO::PARAM_STR);
                
                $company->execute();

                $company = $company->fetchAll(PDO::FETCH_ASSOC);

                return $company;
            } catch (PDOException $exception) {	
                echo "Unable to retrieve record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Retrieve companies by id from the database
         * 
         * @param String $id
         * @return Array $companies
        */
		private function getCustomerCompanies($id) {
			try {
                $companies = "
                    SELECT * FROM users_companies a
                    JOIN companies b
                    ON a.company_id = b.id
                    WHERE user_id = :id
                ";
            
                $companies = $this->conn->prepare($companies);
                $companies->bindValue(':id', $id, PDO::PARAM_STR);
                
                $companies->execute();

                $companies = $companies->fetchAll(PDO::FETCH_ASSOC);

                return $companies;
            } catch (PDOException $exception) {	
                echo "Unable to retrieve record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Delete company from the database
         * 
         * @param String $id
         * @return Void
        */
		private function deleteCompany($id) :void {
			try {
                $company = "
                    DELETE FROM companies
                    WHERE id = :id
                ";
            
                $company = $this->conn->prepare($company);
                $company->bindValue(':id', $id, PDO::PARAM_STR);
                
                $company->execute();
            } catch (PDOException $exception) {	
                echo "Unable to delete record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /** 
         * Public Create Company Interface
         *
        */
        public function create_company($fields) :void {
            $this->createCompany($fields);
        }

        /** 
         * Public Retrieve Company Interface
         * 
         * @param String $id
         * @return Array $company
        */
        public function get_company($id) {
            return $this->getCompany($id);
        }

        /** 
         * Public Retrieve Companies Interface
         * 
         * @param String $id
         * @return Array $companies
        */
        public function get_customer_companies($id) {
            return $this->getCustomerCompanies($id);
        }

        /** 
         * Public Update Company Interface
         *
        */
        public function update_company($fields) :void {
            $this->updateCompany($fields);
        }

        /** 
         * Public Delete Company Interface
         * 
         * @param String $id
         * @return Void
        */
        public function delete_company($id) :void {
            $this->deleteCompany($id);
        }
	}
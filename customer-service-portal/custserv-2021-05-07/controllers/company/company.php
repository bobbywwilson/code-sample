<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
	
	class CompanyController {
		private $validation;
        private $validations;
        private $message;

        public function __construct() {
			$this->validation = new ValidateCreateCompany();
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
         * Store a company in the database
         * 
         * @param Array $fields
         * @return String $validation
        */
		private function createCompany($fields) {
			try {
                $this->validations = $this->validation->validate_create_company($fields);

                if (isset($this->validations['errors']) && count($this->validations['errors']) > 0) {
                    return $this->validations;
                }
                
                $company_fields = [
                    "company_name" => $this->validations["company-name"],
                    "company_contact" => $this->validations["company-contact"],
                    "contact_phone" => $this->validations["contact-phone"],
                    "contact_email" => $this->validations["contact-email"]
                ];

                $company = new Company();

                $company->create_company($company_fields);
                
                unset($company);
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
                
            } catch (PDOException $exception) {	
                echo "Unable to update record(s): " . $exception->getMessage();
                    
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
                $companies = new Company();

                $companies = $companies->get_customer_companies($id);

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
         * @return Array $message
        */
		private function deleteCompany($id) {
			try {
                $company = new Company();

                $company = $company->delete_company($id);

                $this->message[] = "Company has been deleted.";

                return ["success" => $this->message];
            } catch (PDOException $exception) {	
                echo "Unable to delete record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /** 
         * Public Create Company Interface
         * 
         * @param Array $fields
         * @return String $validation
        */
        public function create_company($fields) {
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
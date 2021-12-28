<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
	
	class Product {
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
         * Retrieve companies by name from the database
         * 
         * @param String $id
         * @return Array $companies
        */
		private function getCompanies($id) {
			try {
                $company_name = "
                    SELECT company_name FROM companies
                    WHERE id = :id
                ";
            
                $company_name = $this->conn->prepare($company_name);
                $company_name->bindValue(':id', $id, PDO::PARAM_STR);
                
                $company_name->execute();

                $company_name = $company_name->fetchAll(PDO::FETCH_ASSOC);

                $company_ids = "
                    SELECT id FROM companies
                    WHERE company_name = :company_name
                ";
            
                $company_ids = $this->conn->prepare($company_ids);
                $company_ids->bindValue(':company_name', $company_name[0]['company_name'], PDO::PARAM_STR);
                
                $company_ids->execute();

                $company_ids = $company_ids->fetchAll(PDO::FETCH_ASSOC);

                return $company_ids;
            } catch (PDOException $exception) {	
                echo "Unable to retrieve record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Retrieve products by name from the database
         * 
         * @param String $id
         * @return Array $products
        */
		private function getProducts($id) {
			try {
                $product_name = "
                    SELECT product_name FROM products
                    WHERE id = :id
                ";
            
                $product_name = $this->conn->prepare($product_name);
                $product_name->bindValue(':id', $id, PDO::PARAM_STR);
                
                $product_name->execute();

                $product_name = $product_name->fetchAll(PDO::FETCH_ASSOC);

                $product_ids = "
                    SELECT id FROM products
                    WHERE product_name = :product_name
                ";
            
                $product_ids = $this->conn->prepare($product_ids);
                $product_ids->bindValue(':product_name', $product_name[0]['product_name'], PDO::PARAM_STR);
                
                $product_ids->execute();

                $product_ids = $product_ids->fetchAll(PDO::FETCH_ASSOC);

                return $product_ids;
            } catch (PDOException $exception) {	
                echo "Unable to retrieve record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Stores a product in the database
         * 
         * @param $fields array
         * @return Void
        */
		private function createProduct($fields) {
			try {
                $company_ids = $this->getCompanies($fields['company_id']);

                for ($i = 0; $i < count($company_ids); $i++) {
                    $product = "
                        INSERT INTO products (
                            company_id, 
                            product_name,
                            license_type
                        ) VALUES (
                            :company_id, 
                            :product_name,
                            :license_type
                        )
                    ";
                
                    $product = $this->conn->prepare($product);
                    $product->bindValue(':company_id', $company_ids[$i]['id'], PDO::PARAM_STR);
                    $product->bindValue(':product_name', $fields['product_name'], PDO::PARAM_STR);
                    $product->bindValue(':license_type', $fields['license_type'], PDO::PARAM_STR);
                    
                    $product->execute();
                }
            } catch (PDOException $exception) {	
                echo "Unable to add record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Retrieve product from the database
         * 
         * @param String $id
         * @return Array $product
        */
		private function getProduct($id) {
			try {
                $product = "
                    SELECT * FROM products
                    WHERE id = :id
                ";
            
                $product = $this->conn->prepare($product);
                $product->bindValue(':id', $id, PDO::PARAM_STR);
                
                $product->execute();

                $product = $product->fetchAll(PDO::FETCH_ASSOC);

                return $product;
            } catch (PDOException $exception) {	
                echo "Unable to retrieve record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Delete product from the database
         * 
         * @param String $id
         * @return Array $product
        */
		private function deleteProduct($id) :void {
			try {
                $product_ids = $this->getProducts($id);
                
                for ($i = 0; $i < count($product_ids); $i++) {
                    $product = "
                        DELETE FROM products
                        WHERE id = :id
                    ";
                
                    $product = $this->conn->prepare($product);
                    $product->bindValue(':id', $product_ids[$i]['id'], PDO::PARAM_STR);
                    
                    $product->execute();
                }
            } catch (PDOException $exception) {	
                echo "Unable to delete record(s): " . $exception->getMessage();
                    
                exit();
            }
		}

        /** 
         * Public Create Product Interface
         *
        */
        public function create_product($fields) {
            $this->createProduct($fields);
        }

        /** 
         * Public Get Product Interface
         * 
         * @param String $id
         * @return Array $product
        */
        public function get_product($id) {
            return $this->getProduct($id);
        }

        /** 
         * Public Delete Product Interface
         * 
         * @param String $id
         * @return Void
        */
        public function delete_product($id) :void {
            $this->deleteProduct($id);
        }
	}
<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
	
	class Redirect {
		/**
         * Redirect User
         * 
         * @param String $route
         * @return Void
        */
		private function redirectUser($route) {
			try {
                if (! isset($route)) {
                    exit('Please provide a url to redirct user');
                }

                header('Refresh: 0;' . $route);

                exit();
            } catch (PDOException $exception) {	
                echo "Unable to compete request: " . $exception->getMessage();
                    
                exit();
            }
		}

        /**
         * Public Redirect User Interface
         * 
         * @param String $route
         * @return Void
        */
        public function route($route) {
            return $this->redirectUser($route);
        }
	}
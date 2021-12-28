<?php
    date_default_timezone_set('America/Chicago');

    class Account {
        private $aspire_base;
        private $aspire_password;
        private $aspire_user;

        /**
         * @param string $aspire_base
         * @param string $aspire_password
         * @param string $aspire_user
        */
        public function __construct($aspire_base, $aspire_password, $aspire_user) {
            $this->aspire_base = $aspire_base;
            $this->aspire_password = $aspire_password;
            $this->aspire_user = $aspire_user;
        }

        /**
         * Get Account method that returns account array
         * 
         * @param string $name
         * @return array $account
        */
        private function getAccount($name) {
            $aspire_base = $this->aspire_base;
            $entity = 'Account';
            $query = '?name="' . $name . '"&wildcard=true';
            $username = $this->aspire_user;
            $password = $this->aspire_password;
            $endpoint = $aspire_base . $entity . $query;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $endpoint,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic '. base64_encode($username . ':' . $password)
                )
            ));

            $account = curl_exec($curl);
            $info = curl_getinfo($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error = curl_error($curl);

            $account = json_decode($account, true);

            $account["Metadata"][] = (object)["endpoint" => $endpoint];
            
            return $account;
        }

        /** 
         * Public Get Account Interface
         *
         * @param string $name
         * @return array $account
        */
        public function get_account($name) {
            return $this->getAccount($name);
        }
    }
?>
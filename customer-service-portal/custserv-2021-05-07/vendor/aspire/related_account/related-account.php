<?php
    date_default_timezone_set('America/Chicago');

    class RelatedAccount {
        private $aspire_base;
        private $aspire_password;
        private $aspire_user;

        /**
         * @param $aspire_base string
         * @param $aspire_password
         * @param $aspire_user string
        */
        public function __construct($aspire_base, $aspire_password, $aspire_user) {
            $this->aspire_base = $aspire_base;
            $this->aspire_password = $aspire_password;
            $this->aspire_user = $aspire_user;
        }

        /**
         * Get Related Accounts method that returns Related Accounts array
         * 
         * @param string $id
         * @return array $related_accounts
        */
        private function getRelatedAccounts($id) {
            $aspire_base = $this->aspire_base;
            $entity = 'Contract/Accounts/';
            $query = $id . '/id';
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

            $related_accounts = curl_exec($curl);
            $info = curl_getinfo($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error = curl_error($curl);

            $related_accounts = json_decode($related_accounts, true);

            $related_accounts["Metadata"][] = (object)["endpoint" => $endpoint];
            
            return $related_accounts;
        }

        /** 
         * Public Get Related Accounts Interface
         *
         * @param string $id
         * @return array $related_accounts
        */
        public function get_related_accounts($id) {
            return $this->getRelatedAccounts($id);
        }
    }
?>
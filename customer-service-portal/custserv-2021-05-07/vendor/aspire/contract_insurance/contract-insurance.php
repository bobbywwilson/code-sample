<?php
    date_default_timezone_set('America/Chicago');

    class ContractInsurance {
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
         * Get Contract Insurance method that returns Contract Insurance array
         * 
         * @param string $id
         * @return array $contract_insurance
        */
        private function getContractInsurance($id) {
            $aspire_base = $this->aspire_base;
            $entity = 'Contract/';
            $query = $id . '/id/insurance';
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

            $contract_insurance = curl_exec($curl);
            $info = curl_getinfo($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error = curl_error($curl);

            $contract_insurance = json_decode($contract_insurance, true);

            $contract_insurance["Metadata"][] = (object)["endpoint" => $endpoint];
            
            return $contract_insurance;
        }

        /** 
         * Public Get Contract Insurance Interface
         *
         * @param string $id
         * @return array $contract_insurance
        */
        public function get_contract_insurance($id) {
            return $this->getContractInsurance($id);
        }
    }
?>
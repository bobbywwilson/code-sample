<?php

class CustomerController {
    public function contract_search() {
        $page = "Contract Search";

        include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/header.php");
        include($_SERVER['DOCUMENT_ROOT'] . '/views/customer/contract-search.php');
        include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/footer.php");
    }

    public function contract_list() {
        $page = "List of Contracts";

        include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/header.php");
        include($_SERVER['DOCUMENT_ROOT'] . '/views/customer/search-results.php');
        include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/footer.php");
    }

    public function contract_details() {
        $page = "Contract Details";

        include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/header.php");
        include($_SERVER['DOCUMENT_ROOT'] . '/views/customer/contract-details.php');
        include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/footer.php");
    }
}
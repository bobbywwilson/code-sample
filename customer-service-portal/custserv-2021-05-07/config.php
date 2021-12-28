<?php
    date_default_timezone_set('America/New_York');

    include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");

    (new DotEnv($_SERVER["DOCUMENT_ROOT"] . "/.env"))->load();

    define("ABSOLUTE_PATH", "https://" . $_SERVER["HTTP_HOST"] . "/", false);
    define("RELATIVE_PATH", $_SERVER["DOCUMENT_ROOT"] . "/", false);
?>

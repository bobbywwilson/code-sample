<?php
    spl_autoload_register(function($class) {
        $directorys = array(
            DIRECTORY_SEPARATOR . 'database',
            DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'auth',
            DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'admin',
            DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'user',
            DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'customer',
            DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'company',
            DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'services',
            DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR . 'validators',
            DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'auth',
            DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'admin',
            DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'user',
            DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'role',
            DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'company',
            DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'product'
        );

        foreach ($directorys as $directory) {
            $file = $_SERVER["DOCUMENT_ROOT"] . $directory . DIRECTORY_SEPARATOR . $class . '.php';
            $file = strtolower(str_replace("Controller", "", $file));

            if (file_exists($file)) {
                require_once($file);
            }           
        }
    });
?>
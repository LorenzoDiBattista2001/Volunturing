<?php

    spl_autoload_register(function ($className) {
        $firstChar = $className[0];
        $package = '';

        switch($firstChar) {
            case 'E':
                $package = 'Entity';
                break;
            case 'F':
                $package = 'Foundation';
                break; 
            case 'C':
                $package = 'Controller';
                break;
            case 'V':
                $package = 'View';
                break;
            case 'U':
                $package = 'Utility';
                break;
        }

        $file = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $package . DIRECTORY_SEPARATOR . $className . '.php';
        if(file_exists($file)) {
            require_once($file);
        }

    });

?>
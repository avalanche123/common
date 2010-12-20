<?php

spl_autoload_register(function($class)
{
    $fileCandidate = str_replace('\\', '/', $class) . '.php';
    foreach (array('lib', 'tests') as $dir) {
        $filename = __DIR__ . '/../' . $dir . '/' . $fileCandidate;
        if (file_exists($filename)) {
            require_once $filename;
        }
    }
});
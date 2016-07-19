<?php

function my_autoload($fileName)
{
    $filePath = sprintf('%s.php', str_replace('\\', '/', $fileName));
    if (is_file($filePath)) {
        require_once $filePath;
    }
}

spl_autoload_register('my_autoload');
<?php

$basePath = __DIR__ . '/../storage/framework/testing/views';

if (!is_dir($basePath)) {
    exit;
}

$dirs = array_filter(glob($basePath . '/*'), 'is_dir');

foreach ($dirs as $dir) {
    foreach (glob($dir . '/*.php') as $file) {
        @unlink($file);
    }
    @rmdir($dir);
}

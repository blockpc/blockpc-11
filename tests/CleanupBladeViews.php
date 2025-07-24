<?php

$basePath = __DIR__ . '/../storage/framework/testing/views';

if (!is_dir($basePath)) {
    exit;
}

$dirs = array_filter(glob($basePath . '/*'), 'is_dir');

foreach ($dirs as $dir) {
    foreach (glob($dir . '/*.php') as $file) {
        if (!unlink($file)) {
            error_log("Failed to delete file: $file");
        }
    }
    if (!rmdir($dir)) {
        error_log("Failed to remove directory: $dir");
    }
}

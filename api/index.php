<?php

// Tandai environment Vercel
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// Pastikan direktori storage di dalam /tmp tersedia untuk Vercel serverless environment
$storageDirs = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/testing',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Forward request Vercel ke public/index.php Laravel
require __DIR__ . '/../public/index.php';

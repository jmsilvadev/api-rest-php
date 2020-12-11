<?php

if (file_exists(__DIR__ . '/../c3.php')) {
    include __DIR__ . '/../c3.php';
}

$app = require __DIR__ . '/../app/config/bootstrap.php';

$app->handle(
    $_SERVER['REQUEST_URI']
);

$app->response->send();

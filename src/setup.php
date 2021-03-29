<?php

require_once '../vendor/autoload.php';
use App\DataProvider\DatabaseProvider;

$carbon = new \Carbon\Carbon();

$whoops = new \Whoops\Run();
$whoops->pushHandler(
    new \Whoops\Handler\PrettyPageHandler()
);
$whoops->register();

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbProvider = new DatabaseProvider();

session_start();

if (isset($_SESSION['loginId'])) {
    $loggedInUser = $dbProvider->getUser($_SESSION['loginId']);
}

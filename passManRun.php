<?php


require_once 'vendor/autoload.php';
use App\infrastructure\AccountRepo;

$repo = new AccountRepo();
var_dump($repo->getAccounts());

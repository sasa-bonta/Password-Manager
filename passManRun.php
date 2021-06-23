<?php


require_once 'vendor/autoload.php';
use App\infrastructure\AccountRepo;
use App\src\Account;

# https://github.com/aharabara/passman/blob/master/passman.php

echo "
1 = add
2 = view credentials
3 = edit
4 = delete \n";

$command = (int)readline("Your action: ");
option($command);

function option($option) {
    switch ($option) {
        case 1: echo add(); break;
        case 2: echo view(); break;
        case 3: echo edit(); break;
        case 4: echo "delete \n"; break;
        default: option((int)readline("Your action: ")); break;
    }
}

function add() {
    $site = readline("Site: ");
    $login = readline("Login: ");
    $pass = readline("Password: ");

    $account = new Account($site, $login, $pass);

    $repo = new AccountRepo();
    $repo->addAccount($account);
}

function view() {
    $site = readline("Site: ");
    $repo = new AccountRepo();
    echo "Your accounts on " .$site .": \n";
    foreach ($repo->getCredentials($site) as $account) {
        echo "----------------------- \n";
        echo "|---" ." login    : " .$account['login'] ."\n";
        echo "|---" ." password : " .$account['password'] ."\n";
    }
}

function edit() {
    $site = readline("Site: ");
    $login = readline("Login: ");

    $repo = new AccountRepo();
    $account = $repo->findAccount($site, $login);
//    echo $account->getSite();
//    echo $account->getLogin();
//    echo $account->getPassword();
}

//echo "load \n";
//$repo = new AccountRepo();
//var_dump($repo->getAccounts());
//
//var_dump($repo->findAccount("mail.ru","sasa@mail.ru"));

////echo "add 1 account \n";
////$account = new Account("facebook.com", "sasa123", "sasa1213");
////$repo->addAccount($account);
////var_dump($repo->getAccounts());
//
//echo "founded \n";
//var_dump($repo->getCredentials("facebook.com"));


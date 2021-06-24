<?php


require_once 'vendor/autoload.php';

use App\infrastructure\AccountRepo;
use App\src\Account;

# https://github.com/aharabara/passman/blob/master/passman.php

echo "
1 = add
2 = view credentials
3 = edit
4 = delete account 
5 = all sites
0 = exit \n \n";

option();

function option()
{
    $option = (int)readline("Your action: ");
    switch ($option) {
        case 0:exit();
        case 1:
            add();
            break;
        case 2:
            view();
            break;
        case 3:
            edit();
            break;
        case 4:
            delete();
            break;
        case 5:
            sites();
        default:
            option();
            break;
    }
}

function add()
{
    $site = readline("Site: ");
    $login = readline("Login: ");
    $pass = readline("Password: ");

    $account = new Account($site, $login, $pass);

    $repo = new AccountRepo();
    $repo->addAccount($account);
    $repo->save();
    echo "New account has been added \n";
    echo PHP_EOL;
    option();
}

function view()
{
    $site = readline("Site: ");
    $repo = new AccountRepo();
    echo "Your accounts on " . $site . ": \n";
    foreach ($repo->getCredentials($site) as $account) {
        echo "----------------------- \n";
        echo "|---" . " login    : " . $account['login'] . "\n";
        echo "|---" . " password : " . $account['password'] . "\n";
    }
    $repo->save();
    echo PHP_EOL;
    option();
}

function edit()
{
    $site = readline("Site: ");
    $login = readline("Login: ");

    $repo = new AccountRepo();
    $index = $repo->findAccount($site, $login);
    if (isset($index)) {
        echo "current\n";
        var_dump($repo->getAccounts()[$index]);
        echo "Current password: " . $repo->getAccounts()[$index]['password'] . "\n";
        $newSite = readline("Enter new site: ");
        $newLogin = readline("Enter new login: ");
        $pass = readline("Enter new password: ");

        if ($newSite !== "") {
            $site = $newSite;
        }
        if ($newLogin !== "") {
            $login = $newLogin;
        }
        if ($pass === "") {
            $pass = $repo->getAccounts()[$index]['password'];
        }
        $newAccount = new Account($site, $login, $pass);
        $repo->editAccount($index, $newAccount);
        $repo->save();
        echo "Your account has been updated \n";
    } else {
        echo "This account doesn't exist. Try again \n";
        edit();
    }

    echo PHP_EOL;
    option();
}

function delete()
{
    $site = readline("Site: ");
    $login = readline("Login: ");

    $repo = new AccountRepo();
    $index = $repo->findAccount($site, $login);
    if (isset($index)) {
        echo "Are you sure [y/n] ? \n";
        if (readline() === "y") {
            $repo->deleteAccount($index);
            $repo->save();
            echo "This account has been deleted \n";
        } else {
            echo PHP_EOL;
            option();
        }
    } else {
        echo "This account doesn't exist. Try again \n";
        delete();
    }

    echo PHP_EOL;
    option();
}

function sites() {
    $repo = new AccountRepo();
    echo "\nList of sites: \n-----------------------\n";
    foreach ($repo->allSites() as $site) {
        echo $site ."\n";
    }
    echo PHP_EOL;
}


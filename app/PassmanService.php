<?php


namespace App\app;


use App\infrastructure\AccountRepo;
use App\src\Account;

class PassmanService implements Service
{
    private $repo;

    /**
     * PassmanService constructor.
     * @param $repo
     */
    public function __construct()
    {
        $this->repo = new AccountRepo();
    }

    public function __destruct()
    {
        $this->repo->save();
    }

    public function add(): void
    {
        $site = readline("Site: ");
        $login = readline("Login: ");
        $pass = readline("Password: ");
        $account = new Account($site, $login, $pass);
        $this->repo->addAccount($account);
        $this->repo->save();
        echo "New account has been added \n";
        echo PHP_EOL;
        $this->option();
    }

    public function view(): void
    {
        $site = readline("Site: ");
        echo "Your accounts on " . $site . ": \n";
        foreach ($this->repo->getCredentials($site) as $account) {
            echo "----------------------- \n";
            echo "|---" . " login    : " . $account->getLogin() . "\n";
            echo "|---" . " password : " . $account->getPassword() . "\n";
        }
        echo PHP_EOL;
        $this->option();
    }

    public function edit(): void
    {
        $site = readline("Site: ");
        $login = readline("Login: ");
        
        $index = $this->repo->findAccount($site, $login);
        if (isset($index)) {
            echo "Current password: " . $this->repo->getAccounts()[$index]->getPassword() . "\n";
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
                $pass = $this->repo->getAccounts()[$index]->getPassword();
            }
            $newAccount = new Account($site, $login, $pass);
            $this->repo->editAccount($index, $newAccount);
            $this->repo->save();
            echo "Your account has been updated \n";
        } else {
            echo "This account doesn't exist. Try again \n";
            $this->edit();
        }

        echo PHP_EOL;
        $this->option();
    }

    public function delete(): void
    {
        $site = readline("Site: ");
        $login = readline("Login: ");

        $index = $this->repo->findAccount($site, $login);
        if (isset($index)) {
            echo "Are you sure [y/n] ? \n";
            if (readline() === "y") {
                $this->repo->deleteAccount($index);
                $this->repo->save();
                echo "This account has been deleted \n";
            } else {
                echo PHP_EOL;
                $this->option();
            }
        } else {
            echo "This account doesn't exist. Try again \n";
            $this->delete();
        }

        echo PHP_EOL;
        $this->option();
    }

    public function sites(): void
    {
        echo "\nList of sites: \n-----------------------\n";
        foreach ($this->repo->allSites() as $site) {
            echo $site ."\n";
        }
        echo PHP_EOL;
        $this->option();
    }

    public function option(): void
    {
        $option = (int)readline("Your action: ");
        switch ($option) {
            case 0:exit();
            case 1:
                $this->add();
                break;
            case 2:
                $this->view();
                break;
            case 3:
                $this->edit();
                break;
            case 4:
                $this->delete();
                break;
            case 5:
                $this->sites();
                break;
            default:
                $this->option();
                break;
        }
    }

}
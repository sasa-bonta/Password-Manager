<?php

namespace App\infrastructure;

use App\src\Account;

class AccountRepo implements Repository
{
    private array $accounts = [];

    public function __construct()
    {
        $this->load();
    }

    public function __destruct()
    {
        $this->save();
    }

    public function getAccounts(): ?array
    {
        return $this->accounts;
    }

    # Implemented methods

    public function addAccount(Account $account): bool
    {
        $this->accounts[] = $account;
        return true;
    }

    public function getCredentials(string $site): ?array
    {
        $matchedAccounts = [];
        foreach ($this->accounts as $account) {
            if ($account['site'] === $site) {
                $matchedAccounts[] = $account;
            }
        }

        return $matchedAccounts;
    }

    public function findAccount(string $site, string $login): ?int
    {
        $index = 0;
        foreach ($this->accounts as $account) {
            if ($account['site'] === $site && $account['login'] == $login) {
                return $index;
            }
            $index ++;
        }
        return null;
    }

    public function editAccount(int $index, Account $account): bool
    {
        $this->accounts[$index] = $account;
        return true;
    }

    public function deleteAccount(int $index): bool
    {
        array_splice($this->accounts, $index, 1);
        return true;
    }

    #========================================================

    private function load()
    {
        $fp = fopen(__DIR__ . "/accounts.json", "rb");
        $contents = stream_get_contents($fp);
        fclose($fp);
        $this->accounts = json_decode($contents, TRUE);
    }

    public function save()
    {
        $fp = fopen(__DIR__ . "/accounts.json", "w");
        fwrite($fp, json_encode($this->accounts));
        fclose($fp);
    }
}
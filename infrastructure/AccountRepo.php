<?php

namespace App\infrastructure;

use App\src\Account;

class AccountRepo implements Repository
{
    private array $accounts = [];
    private string $key = "2eOFRNBehdBCJ3067aIA";

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

    public function allSites(): array
    {
        $sites = [];
        foreach ($this->getAccounts() as $account) {
            if (!in_array($account['site'], $sites)) {
                $sites[] = $account['site'];
            }
        }
        return $sites;
    }


    #========================================================

    private function load()
    {
        $fp = fopen(__DIR__ . "/accounts.json", "rb");
        $contents = stream_get_contents($fp);
        fclose($fp);
        $this->accounts = json_decode($this->decrypt($contents), TRUE);
    }

    public function save()
    {
        $fp = fopen(__DIR__ . "/accounts.json", "w");
        fwrite($fp, $this->encrypt(json_encode($this->accounts)));
        fclose($fp);
    }

    #==================== borrowed functions =================

    function decrypt(string $content): string
    {
        $decrypted = '';
        $map = str_pad('', strlen($content), $this->key);
        foreach (str_split($content) as $index => $symbol) {
            $decrypted .= chr(ord($symbol) - ord($map[$index]));
        }

        return $decrypted;
    }

    function encrypt(string $content): string
    {
        $encrypted = '';
        $map = str_pad('', strlen($content), $this->key);
        foreach (str_split($content) as $index => $symbol) {
            $encrypted .= chr(ord($symbol) + ord($map[$index]));
        }

        return $encrypted;
    }
}
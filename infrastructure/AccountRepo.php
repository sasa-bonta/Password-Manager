<?php

namespace App\infrastructure;

use App\src\Account;

class AccountRepo implements Repository
{
    private array $accounts = [];

    /**
     * AccountRepo constructor.
     */
    public function __construct()
    {
        $this->load();
    }

    public function __destruct()
    {
        $this->save();
    }

    /**
     * @return array
     */
    public function getAccounts(): ?array
    {
        return $this->accounts;
    }

    # Implemented methods

    public function addAccount(Account $account): bool
    {
        // TODO: Implement addAccount() method.
    }

    public function getCredentials(string $site): Account
    {
        // TODO: Implement getCredentials() method.
    }

    public function findAccount(string $site, string $login = null): ?Account
    {
        // TODO: Implement findAccount() method.
    }

    public function editAccount(Account $account): bool
    {
        // TODO: Implement editAccount() method.
    }

    public function deleteAccount(string $site): bool
    {
        // TODO: Implement deleteAccount() method.
    }

    #========================================================

    private function load() {
        $fp = fopen(__DIR__ ."/accounts.json", "rb");
        $contents = stream_get_contents($fp);
        fclose($fp);
        $this->accounts = json_decode($contents, TRUE);
    }

    private function save() {
        $fp = fopen(__DIR__ ."/accounts.json", "w");
        fwrite($fp, json_encode($this->accounts));
        fclose($fp);
    }
}
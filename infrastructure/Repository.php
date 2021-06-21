<?php

namespace App\infrastructure;

use App\src\Account;

interface Repository
{
    public function addAccount(Account $account): bool;
    public function getCredentials(string $site): Account;
    public function findAccount(string $site, string $login = null): ?Account;
    public function editAccount(Account $account): bool;
    public function deleteAccount(string $site): bool;
}
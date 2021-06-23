<?php

namespace App\infrastructure;

use App\src\Account;

interface Repository
{
    public function addAccount(Account $account): bool;
    public function getCredentials(string $site): ?array;
    public function findAccount(string $site, string $login): ?Account;
    public function editAccount(Account $account): bool;
    public function deleteAccount(Account $account): bool;
}
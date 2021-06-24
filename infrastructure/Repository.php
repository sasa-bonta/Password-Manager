<?php

namespace App\infrastructure;

use App\src\Account;

interface Repository
{
    public function addAccount(Account $account): bool;
    public function getCredentials(string $site): ?array;
    public function findAccount(string $site, string $login): ?int;
    public function editAccount(int $index, Account $account): bool;
    public function deleteAccount(int $index): bool;
}
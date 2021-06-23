<?php


namespace App\app;


use App\infrastructure\Console;

class PassmanService implements Service
{
    public function addAccount(): bool
    {
        echo Console::green('Hello');
    }

    public function getCredentials(): bool
    {
        // TODO: Implement getCredentials() method.
    }

    public function editAccount(): bool
    {
        // TODO: Implement editAccount() method.
    }

    public function deleteAccount(): bool
    {
        // TODO: Implement deleteAccount() method.
    }
}
<?php


namespace App\app;


interface Service
{
    public function addAccount(): bool;
    public function getCredentials(): bool;
    public function editAccount(): bool;
    public function deleteAccount(): bool;
}
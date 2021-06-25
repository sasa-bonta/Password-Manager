<?php


namespace App\app;


interface Service
{
    public function add(): void;
    public function view(): void;
    public function edit(): void;
    public function delete(): void;
    public function sites(): void;
    public function option(): void;
}
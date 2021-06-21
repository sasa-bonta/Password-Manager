<?php

namespace App\src;

class Account
{
    private string $site;
    private string $login;
    private string $password;

    /**
     * Account constructor.
     * @param string $site
     * @param string $login
     * @param string $password
     */
    public function __construct(string $site, string $login, string $password)
    {
        $this->site = $site;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSite(): string
    {
        return $this->site;
    }

    /**
     * @param string $site
     */
    public function setSite(string $site): void
    {
        $this->site = $site;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
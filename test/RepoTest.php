<?php


namespace App\test;


use App\infrastructure\AccountRepo;
use App\src\Account;
use PHPUnit\Framework\TestCase;

class RepoTest extends TestCase
{
    private AccountRepo $repo;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new AccountRepo();
    }


    /**
     * @dataProvider dataProvider
     */
    public function testEncrypt($json): void
    {
        $encrypted = $this->repo->encrypt($json);
        $decrypted = $this->repo->decrypt($encrypted);
        $this->assertEquals($json, $decrypted, "These values should be equal");
    }

    public function dataProvider()
    {
        return [
            ['vsk.jnfslkvfhbzkfjvz.kndzfknb'],
            [json_encode(new Account('test', 'user', 'password'))]
        ];
    }
}
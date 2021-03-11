<?php declare(strict_types=1);

namespace Test\Unit;

use Controller\UserController;
use Model\User;

class UserControllerFailConnectionTestClass extends UserController
{
    private bool $conectionFailed;


    public function checkConectionFailed()
    {
        return $this->conectionFailed;
    }

    protected function createConnection(string $host, string $user, string $password, string $db)
    {
        $fakeConnection = (new \stdClass());
        $fakeConnection->connect_error = true;
        var_dump($fakeConnection);
        return $fakeConnection;
    }
    public function handleFailOnCreateConnection(): string
    {
        $this->conectionFailed = true;

        return '';
    }

    protected function getUser(): User
    {
        return UserStub::empty();
    }
}
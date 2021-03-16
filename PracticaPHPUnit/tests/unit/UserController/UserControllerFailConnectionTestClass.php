<?php declare(strict_types=1);

namespace Test\Unit\UserController;

use Controller\UserController;
use Model\User;

class UserControllerFailConnectionTestClass extends UserController
{
    private bool $conectionFailed = false;

    protected function handleFailOnCreateConnection(): string
    {
        $this->conectionFailed = true;
        return '';
    }

    public function checkConectionFailed(){
        return $this->conectionFailed;
    }

    protected function getUser(): User
    {
        return new UserStub(6);
    }

    protected function createConnection(string $host, string $user, string $password, string $db)
    {
        return new DbConnectionFailMock();
    }
}
<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Test\Unit\RegisterUser;


use Model\User;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use UseCase\RegisterUser;

class RegisterUserTest extends TestCase
{
    public function testValidUserCanBeRegistered(){
        $dbConnection = new DbConnectionInsertionMock();
        $user = (new RegisterUser($dbConnection))->execute(new UserStub(6));
        $this->assertInstanceOf(User::class, $user);
    }
}
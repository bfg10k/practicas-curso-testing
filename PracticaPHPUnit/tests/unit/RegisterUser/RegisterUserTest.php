<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Test\Unit\RegisterUser;

use Model\User;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Service\DbConnection;
use Service\InsertException;
use Test\Unit\Common\Doubles\UserStub;
use Test\Unit\Common\User\UserMother;
use UseCase\RegisterUser;
use UseCase\UserPersistanceException;

class RegisterUserTest extends TestCase
{
    /**

     */
    public function testValidUserCanBeRegistered(){
        $dbConnection = new DbConnectionInsertionMock();
        $user = (new RegisterUser($dbConnection))->execute(new UserStub(6));
        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     */
    public function invalidUserIsNotRegistered(){
        $this->expectException(UserPersistanceException::class);
        $connection = $this->createStub(DbConnection::class);
        $connection->method('insert')
            ->willThrowException(new InsertException());
        $registerUser = new RegisterUser($connection);
        $registerUser->execute(UserMother::withId());
    }
}
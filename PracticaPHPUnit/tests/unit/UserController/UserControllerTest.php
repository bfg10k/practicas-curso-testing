<?php

namespace Test\Unit\UserController;

use PHPUnit\Framework\TestCase;
use Service\NonValidConnectionException;
use UseCase\UserPersistanceException;
use UseCase\RegisterUser;


class UserControllerTest extends TestCase
{
    /**  */
    public function testConectionHandlerActsOnFail()
    {
        $controller = new UserControllerFailConnectionTestClass();

        $controller->register();

        $this->assertTrue(
            $controller->checkConectionFailed()
        );
    }
}

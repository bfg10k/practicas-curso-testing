<?php


namespace Test\Unit;


use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    public function testHandlerGetsCalledWhenConnectionFails(){

        $controller = new UserControllerFailConnectionTestClass();
        $controller->register();

        $this->assertTrue($controller->checkConectionFailed());
    }
}
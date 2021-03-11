<?php


namespace Test\Unit;


use Model\User;

class UserStub extends User
{
    public function __construct(int $age)
    {
        parent::__construct(
            '',
            $age,
            '',
            '');
    }
}
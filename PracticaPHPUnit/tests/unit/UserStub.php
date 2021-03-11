<?php


namespace Test\Unit;


use Model\User;

class FakeUser
{
    public static function allEmptyButAge(int $age): User
    {
        return new User(
            '',
            $age,
            '',
            ''
        );
    }
}
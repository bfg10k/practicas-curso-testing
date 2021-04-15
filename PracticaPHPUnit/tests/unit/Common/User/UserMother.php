<?php

namespace Test\Unit\Common\User;


use Model\User;

class UserMother
{

    public static function withId(){
        $user =  new User('Juan', 18, 'prueba@mail.com', 'xxxx');
        return $user->setId(1);
    }

    public static function generateAdult()
    {
        return new User('Juan', 18, 'prueba@mail.com', 'xxxx');
    }
}
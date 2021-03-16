<?php

namespace Test\Unit\Common\Doubles;

use Model\User;

class UserStub extends User{
    public function __construct(int $age){
        parent::__construct('', $age, '', '');
    }
}

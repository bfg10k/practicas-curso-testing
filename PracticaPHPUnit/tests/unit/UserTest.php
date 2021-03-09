<?php declare(strict_types=1);

namespace Test\Unit;

use Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    private const LEGAL_AGE_FOR_DRIVING = 18;
    public function testIsAnAdultReturnsFalseForMinors(): void
    {
        $user = new User(17);
        $this->assertFalse($user->isAnAdult());

        $user = new User(6);

        $this->assertFalse($user->isAnAdult());
    }

    public function testIsAnAdultReturnsTrueForOlderThanTresshold(){
        $user = new User(19);
        $this->assertTrue($user->isAnAdult());

        $user = new User(80);
        $this->assertTrue($user->isAnAdult());

        $user = new User(102);
        $this->assertTrue($user->isAnAdult());
    }

    public function testIsAnAdultReturnsTrueForTresshold(){
        $user = new User(self::LEGAL_AGE_FOR_DRIVING);
        $this->assertTrue($user->isAnAdult());
    }
}


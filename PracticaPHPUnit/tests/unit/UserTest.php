<?php declare(strict_types=1);

namespace Test\Unit;

use Test\Unit\UserTest as User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private const LEGAL_AGE_FOR_DRIVING = 18;
    private const MINIMUN_AGE_FOR_PASSENGERS = 6;

    public function testIsAnAdultReturnsFalseForMinors(): void
    {
        $user = new User(17);
        $this->assertFalse($user->isAnAdult());

        $user = new User(6);

        $this->assertFalse($user->isAnAdult());
    }

    public function testIsAnAdultReturnsTrueForOlderThanTresshold()
    {
        $user = new User(19);
        $this->assertTrue($user->isAnAdult());

        $user = new User(80);
        $this->assertTrue($user->isAnAdult());

        $user = new User(102);
        $this->assertTrue($user->isAnAdult());
    }

    public function testIsAnAdultReturnsTrueForTresshold()
    {
        $user = new User(self::LEGAL_AGE_FOR_DRIVING);
        $this->assertTrue($user->isAnAdult());
    }

    public function testPassengersUnderMinimumAgeCantBeCreated()
    {
        $this->expectException(\InvalidArgumentException::class);

        new User(self::MINIMUN_AGE_FOR_PASSENGERS - 1);
    }

    public function testUsersOverMinimumAgeCanBeCreated()
    {
        $this->assertEquals(
            User::class,
            get_class(new User(self::MINIMUN_AGE_FOR_PASSENGERS + 1))
        );
    }

    public function testUsersOfMinimumAgeCanBeCreated()
    {
        $this->assertEquals(
            User::class,
            get_class(new User(self::MINIMUN_AGE_FOR_PASSENGERS))
        );
    }
}


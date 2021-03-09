<?php declare(strict_types=1);

namespace Test\Unit;

use Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserIsAnAdultReturnsFalseForMinors(): void
    {
        $user = new User(16);
        $this->assertEquals(false, $user->isAnAdult());
    }
}


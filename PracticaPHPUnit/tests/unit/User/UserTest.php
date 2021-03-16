<?php 

namespace Test\Unit\User;

use PHPUnit\Framework\TestCase;
use Test\Unit\Common\Doubles\UserStub as User;

class UserTest extends TestCase
{
    private const LEGAL_AGE_FOR_DRIVING = 18;
    
    private const MINIMUM_USER_AGE=6; 

    public function testUserIsAnAdultReturnsFalseForMinors(){
        $user = new User(self::LEGAL_AGE_FOR_DRIVING - 1);
        
        $this->assertFalse($user->isAnAdult());

        $user = new User(6);
        
        $this->assertFalse($user->isAnAdult());
    }

    public function testIsAnAdultReturnsTrueForPeopleOlderThanThreshold(){
        $user = new User(self::LEGAL_AGE_FOR_DRIVING + 1);
        
        $this->assertTrue($user->isAnAdult());

        $user = new User(55);
        
        $this->assertTrue($user->isAnAdult());

        $user = new User(102);
        
        $this->assertTrue($user->isAnAdult());
    }

    public function testIsAnAdultReturnsTrueForTresshold(){
        $user = new User(self::LEGAL_AGE_FOR_DRIVING);
        $this->assertTrue($user->isAnAdult());
    }

    public function testPassengerUnderMinimumAgeCantBeCreated(){
        $this->expectException(\InvalidArgumentException::class);
        new User(self::MINIMUM_USER_AGE-1);
    }

    public function testPassengerOverMinimumAgeCanBeCreated(){
        $this->assertTrue((new User(self::MINIMUM_USER_AGE+1)) instanceof User);

        $this->assertTrue((new User(self::MINIMUM_USER_AGE+20)) instanceof User);

        $this->assertTrue((new User(self::MINIMUM_USER_AGE+80)) instanceof User);
    }

    public function testUsersOfMinimumAgeCanBeCreated(){
        $this->assertTrue(
            (new User(self::MINIMUM_USER_AGE)) instanceof User
        );
    }
}
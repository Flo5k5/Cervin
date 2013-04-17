<?php
namespace SamUserTest\Entity;

use Doctrine\ORM\EntityManager;
use SamUser\Entity\User;

use PHPUnit_Framework_TestCase;

class UserTest extends PHPUnit_Framework_TestCase
{
    public function testUserInitialState()
    {
        $user = new User();

        $this->assertNull($user->id, '"id" should initially be null');
        $this->assertNull($user->username, '"username" should initially be null');
        $this->assertNull($user->email, '"email" should initially be null');
        $this->assertNull($user->displayName, '"displayName" should initially be null');
        $this->assertNull($user->password, '"password" should initially be null');
        $this->assertNull($user->state, '"state" should initially be null');
        $this->assertNull($user->roles, '"roles" should initially be null');
    }
}

<?php
namespace SamUserTest\Entity;

use Doctrine\ORM\EntityManager;
use SamUser\Entity\Role;

use PHPUnit_Framework_TestCase;

class RoleTest extends PHPUnit_Framework_TestCase
{
    public function testRoleInitialState()
    {
        $role = new Role();

        $this->assertNull($role->id, '"id" should initially be null');
        $this->assertNull($role->roleId, '"roleId" should initially be null');
        $this->assertNull($role->parent, '"parent" should initially be null');
    }
}

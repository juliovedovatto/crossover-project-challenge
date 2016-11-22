<?php
namespace tests\models;
use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = User::findOne(['id' => 1]));
        expect($user->email)->equals('admin@newsportal.com');

        expect_not(User::findOne(['id' => 9999]));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByEmail('admin@newsportal.com'));
        expect_not(User::findByEmail('not-admin@newsportal.com'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByEmail('admin@newsportal.com');
        expect($user->name === 'Admin')->equals(true);
        expect($user->validatePassword('admin'))->equals(true);        
    }

}

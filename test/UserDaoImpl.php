<?php

namespace Trzczy\Helpers\Test;


class UserDaoImpl
{
    private $users;

    function __construct()
    {
        $this->users[] = new User('Ion', 'flavio@abc.abc');
        $this->users[] = new User('Marco', 'marco@abc.abc');
    }


    function isUsernameUnique($username)
    {
        foreach ($this->users as $user) {
            /** @noinspection PhpUndefinedMethodInspection */
            if ($user->getUsername() === $username) {
                return false;
            }
        }
        return true;
    }

    function isMailUnique($mail)
    {
        foreach ($this->users as $user) {
            /** @noinspection PhpUndefinedMethodInspection */
            if ($user->getMail() === $mail) {
                return false;
            }
        }
        return true;
    }
}
<?php

namespace Trzczy\Helpers;


class User
{
    private $username;
    private $mail;

    function __construct($username, $mail)
    {
        $this->username = $username;
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }
}


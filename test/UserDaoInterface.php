<?php

namespace Trzczy\Helpers;


interface UserDaoInterface
{
    function isMailUnique($mail);

    function isUsernameUnique($username);
}
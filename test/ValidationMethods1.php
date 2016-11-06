<?php
namespace Trzczy\Helpers;

class ValidationMethods1
{
    private $daoImpl;

    function __construct(...$args)
    {
        if ($daoImpl = $args[0]) {
            $this->daoImpl = $daoImpl;
        }
    }

    function unique(...$args)
    {
        $table = $args[1]['table'];
        $value = $args[0];

        switch ($table):
            case 'username':
                return $this->daoImpl->isUsernameUnique($value);
            case 'email':
                return $this->daoImpl->isMailUnique($value);
        endswitch;
        return false;
    }

    function maxLength(...$args)
    {
        $value = $args[0];

        $ruleData = $args[1];
        $max = $ruleData['max'];
        if (strlen($value) > $max) {
            return false;
        }
        return true;
    }

    function length(...$args)
    {
        $value = $args[0];
        $ruleData = $args[1];
        $min = $ruleData['min'];
        $max = $ruleData['max'];
        if ((strlen($value) < $min) OR (strlen($value) > $max)) {
            return false;
        }
        return true;
    }

    function regex(...$args)
    {
        $value = $args[0];
        $ruleData = $args[1];
        $pattern = $ruleData['pattern'];

        if (preg_match('/' . $pattern . '/', $value)) {
            return true;
        }
        return false;
    }

    function confirm(...$args)
    {
        $value = $args[0];
        $passwordValue = $args[2];
        if ($value !== $passwordValue) {
            return false;
        }
        return true;
    }

    function email(...$args)
    {
        $value = $args[0];
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}
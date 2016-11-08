<?php
namespace Trzczy\Helpers\Test;

class ValidationMethods2
{
    function length()
    {
        $value = func_get_args()[0];
        $ruleData = func_get_args()[1];
        $min = $ruleData['min'];
        $max = $ruleData['max'];
        if ((strlen($value) < $min) OR (strlen($value) > $max)) {
            return false;
        }
        return true;
    }
}
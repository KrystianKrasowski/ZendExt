<?php

namespace ZendExt\Filter;

use Zend\Filter\AbstractFilter;
use Zend\Filter\Exception;

class BcryptPassword extends AbstractFilter
{
    public function filter($value)
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }
}
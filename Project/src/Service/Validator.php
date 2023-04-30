<?php

namespace App\Service;

class Validator
{
    public function checkInputEmail(string $email): bool
    {
        $regexInputString = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i';
        if (preg_match($regexInputString, $email)) {
            return True;
        }
        return False;
    }

    public function checkInputString(string $name): bool
    {
        $regexInputString = '/^[a-zA-Z0-9^@&"().!_$£`~-°¤#,%*µ§:{}+=\/;? #]{2,}$/i';
        if (preg_match($regexInputString, $name)) {
            return True;
        }
        return False;
    }

    public function checkInputPassword(string $password): bool
    {
        $regexInputPassword = '/^[a-zA-Z0-9^@&"().!_$£`~\-çàéèà°¤ù%*µ§:{}+=\/;? #]{12,}$/i';
        if (preg_match($regexInputPassword, $password)) {
            return True;
        }
        return False;
    }

    public function checkInputDate(\DateTime $firstDate, ?\Datetime $secondDate = null): bool
    {
        $currentDate = new \Datetime('NOW');
        if ($firstDate >= $currentDate) {
            if ($secondDate !== null) {
                if ($secondDate > $firstDate) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function transformInputString(string $string): string
    {
        return trim(htmlentities($string));
    }
}
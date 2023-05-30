<?php

class Palindrome {

    /**
    * @param Integer $x
    * @return Boolean
    */
    public static function isPalindrome($x) {
        $y = $x;
        $temp = 0;
        if ($x < 0) {
            return false;
        }

        while ($x != 0) {
            $resve = $x % 10;
            $temp = $temp*10 +  $resve;
            $x = floor($x / 10);
        }

        return $temp == $y;
    }
}

Palindrome::isPalindrome(8);
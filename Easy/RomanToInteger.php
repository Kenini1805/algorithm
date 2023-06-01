<?php
class RomanToInteger {

    /**
     * @param String $string
     * @return Integer
     */
    public static function romanToInt($string) {
        $number = 0;
        $result = 0;
        for ($i= strlen($string) - 1; $i >= 0; $i--) { 
            if ($string[$i] == 'I') {
                if($string[$i + 1])
                $number =  1; 
            }

            if ($string[$i] == 'V') {
                $number = 5; 
            }

            if ($string[$i] == 'X') {
                $number = 10; 
            }

            if ($string[$i] == 'L') {
                $number = 50; 
            }

            if ($string[$i] == 'C') {
                $number = 100; 
            }

            if ($string[$i] == 'D') {
                $number = 500; 
            }

            if ($string[$i] == 'M') {
                $number = 1000; 
            }
            if(4 * $number < $result) {
                $result = $result - $number;
            } else 
            {
                $result = $result + $number;
            }
        }

        return ($result);
    }
}

RomanToInteger::romanToInt('MCMXCIV');

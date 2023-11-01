<?php

class ArrayRotator {
    public static function rotLeftInPlace(&$a, $d) {
        $n = count($a);
        $d = $d % $n;
        if ($d == 0) {
            return $a;
        }

        $gcd = gcd($n, $d);

        for ($i = 0; $i < $gcd; $i++) {
            $temp = $a[$i];
            $j = $i;
            while (true) {
                $k = ($j + $d) % $n;
                if ($k == $i) {
                    break;
                }
                $a[$j] = $a[$k];
                $j = $k;
            }
            $a[$j] = $temp;
        }

        return $a;
    }

    public static function test() {
        $a1 = [1, 2, 3, 4, 5];
        $d1 = 4;
        echo "Test Case 1: Rotated Array - " . implode(' ', $a1) . "\n";

        $a2 = [7, 1, 3, 9, 5, 2, 6];
        $d2 = 2;
        self::rotLeftInPlace($a2, $d2);
        echo "Test Case 2: Rotated Array - " . implode(' ', $a2) . "\n";
    }
}

function gcd($a, $b) {
    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

ArrayRotator::test();


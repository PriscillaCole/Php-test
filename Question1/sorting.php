<?php

function fibonacciFromSortedArray($arr) {
    $fibonacci = [];
    $a = 0;
    $b = 1;
    for ($i = 0; $i < 100; $i++) {
        $c = $a + $b;
        $a = $b;
        $b = $c;
        if ($i >= 6) {
            if (in_array($c, $arr)) {
                $fibonacci[] = $c;
            }
        }
    }
    rsort($fibonacci);
    return $fibonacci;
}

$array = range(0, 100);
$result = fibonacciFromSortedArray($array);
print_r($result);

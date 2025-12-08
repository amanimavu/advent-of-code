<?php
$product_id_ranges = file_get_contents('./input.txt');
$product_id_ranges = explode(",", $product_id_ranges);

function isNumInvalid(string $num_str)
{
    $num_str_len = strlen($num_str);
    $x = (int)($num_str_len / 2);
    $pattern = "/(\d{{$x}})(\d{{$x}})/";
    preg_match($pattern, $num_str, $matches);
    [$_, $f_half, $l_half] = $matches;
    if ($f_half == $l_half) {
        return [true, (int)$num_str];
    }

    if ($f_half > $l_half) {
        return [false, (int)"{$f_half}{$f_half}"];
    }

    return [false, null];
}

$sumOfInvalidIds = 0;
array_walk($product_id_ranges, function ($product_id_range) use (&$sumOfInvalidIds) {
    [$start, $end] = explode("-", $product_id_range);
    for ($i = (int)$start; $i <= (int)$end; $i++) {
        $num_str = (string)$i;
        //check if numbered string has an even length
        if (strlen($num_str) % 2 == 0) {
            [$numIsInvalid, $x] = isNumInvalid($num_str);
            echo $x . PHP_EOL;
            if ($numIsInvalid) {
                $sumOfInvalidIds += $x;
            } else {
                if ($x) {
                    $i = $x - 1;
                } else {
                    continue;
                }
            }
        } else {
            continue;
        }
    }
});

echo PHP_EOL . $sumOfInvalidIds;

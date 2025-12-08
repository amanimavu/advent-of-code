<?php
$product_id_ranges = file_get_contents('./input.txt');
$product_id_ranges = explode(",", $product_id_ranges);

function isNumInvalid(string $num_str, int $num_str_length, array $factors, $upper_limit)
{
    if (count($factors)) {
        foreach ($factors as $factor) {
            $divisor = $num_str_length / $factor;
            $pattern = "/" . str_repeat("(\d{{$divisor}})", $factor) . "/";
            preg_match($pattern, $num_str, $matches);
            $str_chunks = array_slice($matches, 1);
            $oddItem = array_find($str_chunks, function ($chunk) use ($str_chunks) {
                return $chunk != $str_chunks[0];
            });
            if (!isset($oddItem)) {
                return [true, (int)$num_str];
            }
            // $x = str_repeat($str_chunks[0], $factor);
            // if ($x < $upper_limit) {
            //     if ($num_str < $x) {
            //         return [false, (int)"$x"];
            //     }
            // }
        }
    }
    return [false, null];
}

function getFactors(int $num_str_length)
{
    $factors = [];
    for ($i = 2; $i <= $num_str_length; $i++) {
        if ($num_str_length % $i == 0) {
            $factors[] = $i;
        }
    }
    return $factors;
}

$sumOfInvalidIds = 0;
array_walk($product_id_ranges, function ($product_id_range) use (&$sumOfInvalidIds) {
    [$start, $end] = explode("-", $product_id_range);
    for ($i = (int)$start; $i <= (int)$end; $i++) {
        $num_str = (string)$i;
        $num_str_length = strlen($num_str);
        $factors = getFactors($num_str_length);
        [$numIsInvalid, $x] = isNumInvalid($num_str, $num_str_length, $factors, $end);
        if ($numIsInvalid) {
            $sumOfInvalidIds += $x;
        }
    }
});

echo PHP_EOL . $sumOfInvalidIds;

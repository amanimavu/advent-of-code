<?php


$instructions = file('./input.txt', FILE_IGNORE_NEW_LINES);


function getDirectionAndMagnitude(string $str)
{
    preg_match('/(^\w)(\d+)/', $str, $matches);
    [$_, $direction, $magnitude] = $matches;
    return [$direction, $magnitude];
}

function evaluateClick(array $instruction, $position)
{
    $finalPos = $position;
    echo "$position, {$instruction[0]}{$instruction[1]} => ";
    if ($instruction[0] === 'R') {
        $finalPos += (int)$instruction[1];
    } else {
        $finalPos -= (int)$instruction[1];
    }

    switch (true) {
        case $finalPos < 0:
            $factor = ceil($finalPos / -100);
            $finalPos += (100 * $factor);
            if ($position == 0 && $finalPos % 100 != 0) {
                --$factor;
            }
            if ($finalPos == 0 && $position != 0) {
                ++$factor;
            }
            // $factor += $finalPos == 0 ? 1 : 0;
            break;
        case $finalPos > 99:
            $factor = (int)($finalPos / 100);
            $finalPos -= (100 * $factor);
            break;
        default:
            $factor = $finalPos == 0 ? 1 : 0;
    }

    echo "$finalPos" . PHP_EOL;

    return [$finalPos, $factor];
}

$position = 50;
$clicks = 0;

foreach ($instructions as $instruction) {
    $instruction = getDirectionAndMagnitude($instruction);
    [$pos, $clickCounts] = evaluateClick($instruction, $position);
    $position = $pos;
    $clicks += (int)$clickCounts;
}

echo $clicks . PHP_EOL;

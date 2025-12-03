<?php
$instructions = file('./input.txt', FILE_IGNORE_NEW_LINES);
// print_r($file);
// echo count($instructions) . PHP_EOL;

function getDirectionAndMagnitude(string $str)
{
    preg_match('/(^\w)(\d+)/', $str, $matches);
    [$_, $direction, $magnitude] = $matches;
    return [$direction, $magnitude];
}

function evaluateTick(array $instruction, int $position): int
{
    if ($instruction[0] === 'R') {
        $position += (int)$instruction[1];
    } else {
        $position -= (int)$instruction[1];
    }

    switch (true) {
        case $position < 0:
            $factor = ceil($position / -100);
            $position += (100 * $factor);
            break;
        case $position > 99:
            $factor = (int)($position / 100);
            $position -= (100 * $factor);
            break;
        default:
    }
    return $position;
}

$position = 50;
$tick = 0;

foreach ($instructions as $instruction) {
    $instruction = getDirectionAndMagnitude($instruction);
    $position = evaluateTick($instruction, $position);
    if ($position === 0) {
        $tick += 1;
    }
}
echo $tick . PHP_EOL;

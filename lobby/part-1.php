<?php
$inputLines = file('./input.txt', FILE_IGNORE_NEW_LINES);
$batteryBankLength = strlen($inputLines[0]);

function batteryTurner(string $batteryBank)
{
    global $batteryBankLength;
    $bucket_1 = $batteryBank[0];
    $bucket_2 = $batteryBank[$batteryBankLength - 1];

    for ($i = 1; $i < $batteryBankLength - 1; $i++) {
        if ($batteryBank[$i] > $bucket_1) {
            $bucket_1 = $batteryBank[$i];
            $bucket_2 = $batteryBank[$batteryBankLength - 1];
        } else {
            if (abs(9 - $batteryBank[$i]) < abs(9 - $bucket_2)) {
                $bucket_2 = $batteryBank[$i];
            }
        }
    }

    return "{$bucket_1}{$bucket_2}";
}

$sum = 0;
foreach ($inputLines as $inputLine) {
    $result = (int)batteryTurner($inputLine);
    $sum += $result;
}

echo $sum . PHP_EOL;

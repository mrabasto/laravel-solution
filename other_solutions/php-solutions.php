<?php

function shortestWord($str)
{
    return min(array_map('strlen', explode(' ', $str)));
}

echo shortestWord("TRUE FRIENDS ARE ME AND YOU") . "\n";
echo shortestWord("I AM THE LEGENDARY VILLAIN") . "\n";
echo "\n";

function mapIslands($arr)
{
    return array_map(function ($row) {
        return array_map(
            fn ($value) => ($value === 1) ? 'X' : '~',
            $row
        );
    }, $arr);
}

$array = [
    [1, 0, 1, 1, 1],
    [0, 1, 0, 0, 0],
    [1, 1, 0, 1, 0],
    [0, 0, 0, 0, 1],
    [1, 1, 0, 1, 0],
];

$updatedArray = mapIslands($array);

echo "\n";
foreach ($updatedArray as $row) {
    echo implode('', $row) . "\n";
}
echo "\n";

function findWordIndices($words, $target) {
    $indices = array_keys($words, $target);
    return $indices;
}

// Example usage:
$words = ["I", "TWO", "FORTY", "THREE", 'JEN', "TWO", "tWo", "Two"];
$target = "TWO";

[$first, $last] = findWordIndices($words, $target);

echo "TARGET: '{$target}' \n";
echo "INDEX {$first} and {$last} : [{$first},{$last}]";
<?php

$filename = "test-file.txt"; 

function removeDuplicatesFromFile($filename) {
    $content = file_get_contents($filename);
    $words = preg_split('/\s+/', $content);
    $uniqueWords = array_unique($words);
    return $uniqueWords;
}

$result = removeDuplicatesFromFile($filename);
print_r($result);
?>

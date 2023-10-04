<?php
$filename = "test-file.txt"; 

function getPunctuationMarksFromFile($filename) {
    $content = file_get_contents($filename);
    $punctuation = preg_replace('/[a-zA-Z0-9\s]/', '', $content);
    return str_split($punctuation);
}

$result = getPunctuationMarksFromFile($filename);
print_r($result);
?>

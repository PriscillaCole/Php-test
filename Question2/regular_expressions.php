<?php
$paragraph = "This is a paragraph and it has to find 256781123456, testemail@gmail.com and https://kanzucode.com/";

function getEmailUsingRegex($paragraph) {
    $pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/';
    preg_match($pattern, $paragraph, $matches);
    return $matches[0];
}

function getPhoneNumberUsingRegex($paragraph) {
    $pattern = '/\d{12}/';
    preg_match($pattern, $paragraph, $matches);
    return $matches[0];
}

function getUrlUsingRegex($paragraph) {
    $pattern = '/https:\/\/[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/';
    preg_match($pattern, $paragraph, $matches);
    return $matches[0];
}

$email = getEmailUsingRegex($paragraph);
$phoneNumber = getPhoneNumberUsingRegex($paragraph);
$url = getUrlUsingRegex($paragraph);

echo "Email: $email\n";
echo "Phone Number: $phoneNumber\n";
echo "URL: $url\n";

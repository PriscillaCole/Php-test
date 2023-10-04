<?php
$paragraph = "This is a paragraph and it has to find 256781123456, testemail@gmail.com and https://kanzucode.com/";

function getEmailWithoutRegex($paragraph) {
    $email = filter_var($paragraph, FILTER_VALIDATE_EMAIL);
    return $email;
}

function getPhoneNumberWithoutRegex($paragraph) {
    preg_match('/\d{12}/', $paragraph, $matches);
    return $matches[0];
}

function getUrlWithoutRegex($paragraph) {
    $url = filter_var($paragraph, FILTER_VALIDATE_URL);
    return $url ;
}

$email = getEmailWithoutRegex($paragraph);
$phoneNumber = getPhoneNumberWithoutRegex($paragraph);
$url = getUrlWithoutRegex($paragraph);

echo "Email: $email \n";
echo "Phone Number: $phoneNumber \n";
echo "URL: $url \n";

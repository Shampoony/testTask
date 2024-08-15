<?php
require 'vendor/autoload.php';

use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;

$query = $_REQUEST['q'];
$token = '9be5056154065ed09eda3649b1c48ee1';

function validateNum($phoneNumberStr) {
    $phoneUtil = PhoneNumberUtil::getInstance();
    try {
        $phoneNumber = $phoneUtil->parse($phoneNumberStr);
        $countryCode = $phoneUtil->getRegionCodeForNumber($phoneNumber);
        return $phoneUtil->getCountryCodeForRegion($countryCode);
    } catch (NumberParseException $e) {
        return false;
    }
}

if ($query !== '') {
    $len = strlen($query);
    if ($len > 5) {
        $countryName = validateNum($query);
        if ($countryName !== false) {
            $url = "http://htmlweb.ru/geo/api.php?json&telcod=$query&html&charset=utf-8&api_key=$token";
            $response = file_get_contents($url);
            
            if ($response === false) {
                echo "Ошибка запроса к API";
            } else {
                $data = json_decode($response, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($data['country']['name'])) {
                    echo $data['country']['name'];
                } else {
                    echo "Не удалось определить страну";
                }
            }
        } else {
            echo 'К сожалению, страны с таким номером не существует';
        }
    } 
}

<?php
namespace app\controllers;

class Time extends \app\core\Controller{ 
    public static function convertDateTime($dateTime) {
        $date = new \DateTime($dateTime, new \DateTimeZone('UTC'));
        $tz = new \DateTimeZone(date_default_timezone_get());
        $date->setTimeZone($tz);
        return $date->format('Y-m-d H:i:sP e');
    }
}
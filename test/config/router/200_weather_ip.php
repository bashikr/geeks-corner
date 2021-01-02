<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "WEATHER IP",
            "mount" => "ip-weather",
            "handler" => "\Bashar\Weather\WeatherIpController",
        ],
    ]
];

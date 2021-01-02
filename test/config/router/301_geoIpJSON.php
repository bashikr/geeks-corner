<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Geo Location IP validator",
            "mount" => "geo-ip-json",
            "handler" => "\Bashar\IpValidator\JsonGeoLocationByIpController",
        ],
    ]
];

<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Geo Location IP validator",
            "mount" => "geo-ip-normal",
            "handler" => "\Bashar\IpValidator\NormalGeoLocationByIpController",
        ],
    ]
];

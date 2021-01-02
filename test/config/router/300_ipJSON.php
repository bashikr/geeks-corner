<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "IP validator with json response",
            "mount" => "ip-to-json",
            "handler" => "\Bashar\IpValidator\JsonIpValidatorController",
        ],
    ]
];

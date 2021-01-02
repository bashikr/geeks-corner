<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "IP validator",
            "mount" => "ip-validate",
            "handler" => "\Bashar\IpValidator\IpValidatorController",
        ],
    ]
];

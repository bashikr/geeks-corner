<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "curl" => [
            "shared" => true,
            //"callback" => "\Anax\Response\Response",
            "callback" => function () {
                $curl = new \Bashar\WeatherModel\Curl();
                return $curl;
            }
        ],
    ],
];

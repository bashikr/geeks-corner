<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "openWeatherMap" => [
            // Is the service shared, true or false
            // Optional, default is true
            "shared" => true,

            // Is the service activated by default, true or false
            // Optional, default is false
            "active" => true,

            // Callback executed when service is activated
            // Create the service, load its configuration (if any)
            // and set it up.
            "callback" => function () {
                $openWeatherMapModel = new \Bashar\WeatherModel\OpenWeatherMapModel();

                // Load the configuration files
                $cfg = $this->get("configuration");
                $config = $cfg->load("OpnWrMpToken.php");
                $settings = $config["config"] ?? null;

                if ($settings["message"] ?? null) {
                    $openWeatherMapModel->setMessage($settings["message"]);
                }

                return $openWeatherMapModel;
            }
        ],
    ],
];

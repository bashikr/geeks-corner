<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",
 
    // Here comes the menu items
    "items" => [
        [
            "text" => "HOME",
            "url" => "",
            "icon" => "./img/about.png",
            "title" => "Home page",
        ],
        [
            "text" => "QUESTIONS",
            "url" => "questions",
            "title" => "Questions",
        ],
        [
            "text" => "TAGS",
            "url" => "tags",
            "title" => "Tags",
        ], 
        [
            "text" => "MY PROFILE",
            "url" => "user",
            "title" => "My profile",
        ],
        [
            "text" => "ABOUT",
            "url" => "about",
            "title" => "About",
        ],
    ],
];

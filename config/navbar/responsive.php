<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "id" => "rm-menu",
    "wrapper" => null,
    "class" => "rm-default rm-mobile",
 
    // Here comes the menu items
    "items" => [
        [
            "text" => "HOME",
            "url" => "home",
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

<?php

return [

    /*
    |--------------------------
    | Storyblok API parameters
    |--------------------------
    |
    | For generating a new access token or
    | retrieving an existent one (preivew or public),
    | you can go to Settings in your space:
    | https://www.storyblok.com/faq/retrieve-and-generate-access-tokens
    |
    */
    'access_token' => env('STORYBLOK_ACCESS_TOKEN', ''),
    'version' => env('STORYBLOK_VERSION'),
];

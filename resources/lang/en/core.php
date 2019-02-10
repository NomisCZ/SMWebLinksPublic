<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Core Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'title' => [
        'author' => 'Author',
        'version' => 'Version',
        'settings' => 'Settings',
        'cookies' => 'Cookies',
        'security' => 'Security',
    ],
    'info' => [
        'copyright' => 'All rights reserved.',
        'cookies' => 'This site use cookies to store information to your browser. Cookies ensure proper operation of the site.',
        'security' => 'Please take care if you are using HTTPS. Address line must contain https:// (green lock - a secure connection).',
        'logout-success' => [
            'title' => 'Logout was successful.',
            'text' => 'Also, all temporary data for our API in the browser have been deleted.',
        ],
        'logout-not' => [
            'title' => 'You are not logged.',
            'text' => 'We did not find any temporary data in your browser.',
        ]
    ],
    'web.work' => 'Work in progress',
    'title.language' => 'Language',
    'lang' => [
        'select' => 'Select language',
        'cz' => 'Czech',
        'en' => 'English',
    ],
    'text' => [
        'return-home' => 'return home',
        'try-again' => 'try again',
    ],
    'error' => [
        'maintenance' => [
            'title' => 'Maintenance',
            'text' => 'Please come back later. We are currently in maintenance mode, please check back shortly',
        ],
        'page-not-found' => [
            'title' => 'Oops! Page not found.',
            'text' => 'We could not find the page you were looking for. Meanwhile, you may check URL adress.',
        ],
        'login-canceled' => [
            'title' => 'You canceled Steam login.',
            'text' => 'We are sorry, but your redirect request could not be completed, because your canceled Steam login.',
        ],
        'item-not-found' => [
            'title' => 'Oops! Item not found.',
            'text' => 'We could not find the item you were looking for. Meanwhile, you may check URL adress.',
        ],
        'no-method' => [
            'title' => 'Oops! Method not allowed.',
            'text' => 'The method received in the request-line is known by the origin server but not supported by the target resource.',
        ],
        'no-permissions' => [
            'title' => 'You don\'t have permission.',
            'text' => 'Sorry, but you don\'t have permission. This area is restricted, please contact your administrator.',
        ],
        'system-error' => [
            'title' => 'Oops! Something went wrong.',
            'text' => 'Sorry, but the system is temporarily unavailable.',
        ],
        'request-failed' => [
            'title' => 'Oops! No request found.',
            'text' => 'We are sorry, but your redirect request could not be completed, because there is no request for you.',
        ],
        'request-not-available' => [
            'title' => 'Oops! The requested page is not available.',
            'text' => 'We are sorry, but requested page is not available. The page returned a bad response.',
        ],
    ],
];

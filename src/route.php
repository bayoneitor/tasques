<?php

function getRoute(): string
{

    if (isset($_REQUEST['url'])) {
        $url = $_REQUEST['url'];
    } else {
        $url = 'home';
    }
    switch ($url) {
        case 'login':
            return 'login';
        case 'profile':
            return 'profile';
        case 'register':
            return 'register';
        case 'regaction':
            return 'regaction';
        case 'logaction':
            return 'logaction';
        case 'dashboard':
            return 'dashboard';
        case 'dasaction':
            return 'dasaction';
        case 'logout':
            return 'logout';
        case 'home':
            return 'home';
        default:
            return 'home';
    }
}

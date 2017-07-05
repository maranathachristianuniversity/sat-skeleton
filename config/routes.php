<?php

$routes['page'] = array(
    '' => [
        'controller' => 'main',
        'function' => 'main',
        'accept' => ['GET', 'POST'],
    ]
);

$routes['error'] = array(
    'controller' => '',
    'function' => '',
    'accept' => ['GET'],
);

$routes['not_found'] = array(
    'controller' => '',
    'function' => '',
    'accept' => ['GET'],
);

return $routes;
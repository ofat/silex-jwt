Silex JWT
=========
Library for work with JWT on Silex framework. 

You can generate and check JWT tokens, use middleware for auth checking.

Installation
============
`
composer require ofat\silex-jwt
`

Usage
-----
1. Register service provider:

```php
<?php

use Ofat\SilexJWT\JWTAuth;
use Silex\Application;

//Start our application
$app = new Silex\Application();

//Register silex jwt service provider. Add jwt secret key
$app->register(new JWTAuth(),[
    'jwt.secret' => 'test'
]);

//Example of jwt generating
$app->post('/login', function(Request $request) use ($app) {
    $userId = 1;
    $token = $app['jwt_auth']->generateToken($userId);

    return $app->json(['token' => $token]);
});

//Example of checking json web token
$app->get('/test', function(Request $request) use ($app) {
    return $app->json(['test' => true]);
})->before(new JWTTokenCheck());
`
<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use toubeelib\app\auth\application\actions\PostRefreshAction;
use toubeelib\app\auth\application\actions\PostRegisterAction;
use toubeelib\app\auth\application\actions\PostSigninAction;

return function( \Slim\App $app):\Slim\App {


    // S'authentifier
    $app->post('/signin', PostSigninAction::class)
        ->setName('signin');

    $app->post('/register', PostRegisterAction::class)
        ->setName('register');

    $app->post('/refresh', PostRefreshAction::class)
        ->setName('refresh');

    $app->get('/tokens/validate', \toubeelib\app\auth\application\actions\GetValidateTokenAction::class)
        ->setName('validate');
    return $app;
};
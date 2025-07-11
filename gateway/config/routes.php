<?php

use Slim\App;
use toubeelib\gateway\application\actions\ConsulterPraticienByIdAction;
use toubeelib\gateway\application\actions\ConsulterPraticiensAction;
use toubeelib\gateway\application\actions\GenericGetPraticienAction;
use toubeelib\gateway\application\actions\GenericGetRdvsAction;
use toubeelib\gateway\application\actions\HomeAction;
use toubeelib\gateway\application\actions\RefreshTokenAction;
use toubeelib\gateway\application\actions\RegisterAction;
use toubeelib\gateway\application\actions\SignInAction;
use toubeelib\gateway\application\middlewares\AuthMiddleware;

return function(App $app): App {

    $app->get('/', HomeAction::class);
//    $app->get('/praticiens', ConsulterPraticiensAction::class);
//    $app->get('/praticiens/{id}', ConsulterPraticienByIdAction::class);
    $app->post('/register', RegisterAction::class);
    $app->post('/signin', SignInAction::class);
    $app->post('/refresh', RefreshTokenAction::class);

    $app->map(['GET', 'POST', 'PUT', 'PATCH'], '/praticiens[/{id}]', GenericGetPraticienAction::class);

    $app->map(['GET', 'POST', 'PUT', 'PATCH'], '/rdvs/{id}', GenericGetRdvsAction::class)
        ->add(AuthMiddleware::class);

    return $app;
};
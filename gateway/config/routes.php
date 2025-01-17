<?php

use Slim\App;
use toubeelib\gateway\application\actions\ConsulterPraticienByIdAction;
use toubeelib\gateway\application\actions\ConsulterPraticiensAction;
use toubeelib\gateway\application\actions\GenericGetPraticienAction;
use toubeelib\gateway\application\actions\HomeAction;

return function(App $app): App {

    $app->get('/', HomeAction::class);
//    $app->get('/praticiens', ConsulterPraticiensAction::class);
//    $app->get('/praticiens/{id}', ConsulterPraticienByIdAction::class);

    $app->map(['GET', 'POST', 'PUT', 'PATCH'], '/praticiens[/{id}]', GenericGetPraticienAction::class);

    return $app;
};
<?php

use Slim\App;
use toubeelib\gateway\application\actions\ConsulterPraticienByIdAction;
use toubeelib\gateway\application\actions\ConsulterPraticiensAction;
use toubeelib\gateway\application\actions\GenericGetPraticienAction;
use toubeelib\gateway\application\actions\GenericGetRdvsAction;
use toubeelib\gateway\application\actions\HomeAction;

return function(App $app): App {

    $app->get('/', HomeAction::class);
//    $app->get('/praticiens', ConsulterPraticiensAction::class);
//    $app->get('/praticiens/{id}', ConsulterPraticienByIdAction::class);
    $app->post('/register');
    $app->post('/signin');
    $app->post('refresh');

    $app->map(['GET', 'POST', 'PUT', 'PATCH'], '/praticiens[/{id}[/dispo]]', GenericGetPraticienAction::class);

    $app->map(['GET', 'POST', 'PUT', 'PATCH'], '/rdvs/{id}', GenericGetRdvsAction::class);

    return $app;
};
<?php

use Slim\App;

return function(App $app): App {

    $app->get('/', \toubeelib\gateway\application\actions\HomeAction::class);
    $app->get('/praticiens/{id}', \toubeelib\gateway\application\actions\ConsulterPraticienAction::class);

    return $app;
};
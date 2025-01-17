<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use toubeelib\app\praticiens\application\actions\GetPraticienByIdAction;
use toubeelib\app\praticiens\application\actions\GetPraticiensActions;

return function( \Slim\App $app):\Slim\App {

    // Affiches tous les praticiens
    $app->get('/praticiens', GetPraticiensActions::class)
        ->setName('praticiens');
    // Affiche un praticien
    $app->get('/praticiens/{id}', GetPraticienByIdAction::class);

    return $app;
};
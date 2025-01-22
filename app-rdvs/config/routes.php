<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {

    // Affiche un rendez-vous
    $app->get('/rdvs/{id}', \toubeelib\app\rdvs\application\actions\GetRdvByIdAction::class)
        ->setName('rdvs');
    // Modifier un rendez-vous
    $app->patch('/rdvs/{id}', \toubeelib\app\rdvs\application\actions\PatchRdvAction::class);
    // Annuler un rendez-vous
    $app->delete('/rdvs/{id}', \toubeelib\app\rdvs\application\actions\AnnulerRdvAction::class);
    // Crée un rendez-vous
    $app->post('/rdvs', \toubeelib\app\rdvs\application\actions\PostNewRdvAction::class);

    return $app;
};
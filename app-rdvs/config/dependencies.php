<?php

use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use Psr\Http\Client\ClientInterface;
use toubeelib\app\praticiens\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\app\rdvs\application\actions\AnnulerRdvAction;
use toubeelib\app\rdvs\application\actions\GetRdvByIdAction;
use toubeelib\app\rdvs\application\actions\PatchRdvAction;
use toubeelib\app\rdvs\application\actions\PostNewRdvAction;
use toubeelib\app\rdvs\core\repositoryInterfaces\RdvRepositoryInterface;
use toubeelib\app\rdvs\core\services\rdv\ServiceRdv;
use toubeelib\app\rdvs\core\services\rdv\ServiceRdvInterface;
use toubeelib\app\rdvs\infrastructure\adapter\PraticienClientAdapter;
use toubeelib\app\rdvs\infrastructure\repositories\PDORdvRepository;

return [

    RdvRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDORdvRepository();
    },

    'rdvs.client' => function () {
        return new Client([
            'base_uri' => 'http://rdvs.toubeelib',
            'timeout' => 2.0,
        ]);
    },

    PraticienClientAdapter::class => function (ContainerInterface $c) {
        return new PraticienClientAdapter(
            $c->get('rdvs.client')
        );
    },

    ServiceRdvInterface::class => function (ContainerInterface $c) {
        return new ServiceRdv(
            $c->get(PraticienClientAdapter::class),
            $c->get(RdvRepositoryInterface::class)
        );
    },

    // #####################
    //      Actions
    // #####################

    AnnulerRdvAction::class => function (ContainerInterface $c) {
        return new AnnulerRdvAction(
            $c->get(ServiceRdvInterface::class),
        );
    },

    GetRdvByIdAction::class => function (ContainerInterface $c) {
        return new GetRdvByIdAction(
            $c->get(ServiceRdvInterface::class)
        );
    },

    PatchRdvAction::class => function (ContainerInterface $c) {
        return new PatchRdvAction(
            $c->get(ServiceRdvInterface::class),
        );
    },

    PostNewRdvAction::class => function (ContainerInterface $c) {
        return new PostNewRdvAction(
            $c->get(ServiceRdvInterface::class),
        );
    },

];
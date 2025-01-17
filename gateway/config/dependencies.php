<?php

use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use toubeelib\gateway\application\actions\ConsulterPraticienByIdAction;
use toubeelib\gateway\application\actions\ConsulterPraticiensAction;
use toubeelib\gateway\application\actions\GenericGetPraticienAction;
use toubeelib\gateway\application\actions\HomeAction;

return [

    'toubeelib.client' => function () {
        return new Client([
            'base_uri' => 'http://api.toubeelib',
            'timeout' => 2.0,
        ]);
    },

    HomeAction::class => function (ContainerInterface $c) {
        return new HomeAction(
            $c->get('toubeelib.client')
        );
    },

    ConsulterPraticiensAction::class => function (ContainerInterface $c) {
        return new ConsulterPraticiensAction(
            $c->get('toubeelib.client')
        );
    },

    ConsulterPraticienByIdAction::class => function (ContainerInterface $c) {
        return new ConsulterPraticienByIdAction(
            $c->get('toubeelib.client')
        );
    },

    GenericGetPraticienAction::class => function (ContainerInterface $c) {
        return new GenericGetPraticienAction(
            $c->get('toubeelib.client')
        );
    },
];
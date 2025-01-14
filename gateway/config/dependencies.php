<?php

use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use toubeelib\gateway\application\actions\ConsulterPraticienAction;
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

    ConsulterPraticienAction::class => function (ContainerInterface $c) {
        return new ConsulterPraticienAction(
            $c->get('toubeelib.client')
        );
    },
];
<?php

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use toubeelib\gateway\application\actions\ConsulterPraticienAction;
use toubeelib\gateway\application\actions\HomeAction;

return [

    ClientInterface::class => function () {
        return new Client([
            'base_uri' => 'http://localhost:6080',
            'timeout' => 2.0,
        ]);
    },

    HomeAction::class => function (ClientInterface $c) {
        return new HomeAction(
            $c->get(ClientInterface::class)
        );
    },

    ConsulterPraticienAction::class => function (ClientInterface $c) {
        return new ConsulterPraticienAction(
            $c->get(ClientInterface::class)
        );
    },
];
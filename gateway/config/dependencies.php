<?php

use GuzzleHttp\ClientInterface;
use toubeelib\gateway\application\actions\ConsulterPraticienAction;

return [

    ClientInterface::class => function () {
        return new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8080',
            'timeout' => 2.0,
        ]);
    },

    ConsulterPraticienAction::class => function (ClientInterface $c) {
        return new ConsulterPraticienAction(
            $c->get(ClientInterface::class)
        );
    },
];
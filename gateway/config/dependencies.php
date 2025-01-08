<?php

use Psr\Container\ContainerInterface;
use toubeelib\gateway\application\actions\ConsulterPraticienAction;

return [

    ConsulterPraticienAction::class => function (ContainerInterface $c) {
        return new ConsulterPraticienAction(
            $c->get('remote_praticien_service')
        );
    },
];
<?php

use Psr\Container\ContainerInterface;
use toubeelib\app\praticiens\actions\GetPraticienByIdAction;
use toubeelib\app\praticiens\actions\GetPraticiensActions;
use toubeelib\app\praticiens\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\app\praticiens\core\services\praticien\ServicePraticien;
use toubeelib\app\praticiens\core\services\praticien\ServicePraticienInterface;
use toubeelib\app\praticiens\infrastructure\repositories\PDOPraticienRepository;

return [

    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDOPraticienRepository();
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien(
            $c->get(PraticienRepositoryInterface::class)
        );
    },

    // #####################
    //      Actions
    // #####################

    GetPraticienByIdAction::class => function (ContainerInterface $c) {
        return new GetPraticienByIdAction(
            $c->get(ServicePraticienInterface::class)
        );
    },

    GetPraticiensActions::class => function (ContainerInterface $c) {
        return new GetPraticiensActions(
            $c->get(ServicePraticienInterface::class)
        );
    },

];
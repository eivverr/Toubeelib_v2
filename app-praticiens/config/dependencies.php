<?php

use Psr\Container\ContainerInterface;
use toubeelib\app\praticiens\actions\GetDispoPraticienAction;
use toubeelib\app\praticiens\actions\GetPraticienByIdAction;
use toubeelib\app\praticiens\actions\GetPraticiensActions;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterface;
use toubeelib\core\services\praticien\ServicePraticien;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\services\rdv\ServiceRdv;
use toubeelib\core\services\rdv\ServiceRdvInterface;
use toubeelib\infrastructure\repositories\PDOPraticienRepository;
use toubeelib\infrastructure\repositories\PDORdvRepository;

return [

    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDOPraticienRepository();
    },

    RdvRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDORdvRepository();
    },

    ServiceRdvInterface::class => function (ContainerInterface $c) {
        return new ServiceRdv(
            $c->get(PraticienRepositoryInterface::class),
            $c->get(RdvRepositoryInterface::class)
        );
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien(
            $c->get(PraticienRepositoryInterface::class)
        );
    },

    // #####################
    //      Actions
    // #####################

    GetDispoPraticienAction::class => function (ContainerInterface $c) {
        return new GetDispoPraticienAction(
            $c->get(ServiceRdvInterface::class),
        );
    },

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
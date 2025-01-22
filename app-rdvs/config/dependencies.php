<?php

use Psr\Container\ContainerInterface;
use toubeelib\app\rdvs\application\actions\AnnulerRdvAction;
use toubeelib\app\rdvs\application\actions\GetRdvByIdAction;
use toubeelib\app\rdvs\application\actions\PatchRdvAction;
use toubeelib\app\rdvs\application\actions\PostNewRdvAction;
use toubeelib\app\rdvs\core\repositoryInterfaces\RdvRepositoryInterface;
use toubeelib\app\rdvs\core\services\rdv\ServiceRdv;
use toubeelib\app\rdvs\core\services\rdv\ServiceRdvInterface;
use toubeelib\app\rdvs\infrastructure\repositories\PDORdvRepository;

return [

    RdvRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDORdvRepository();
    },

    ServiceRdvInterface::class => function (ContainerInterface $c) {
        return new ServiceRdv(
            $c->get(PraticienRepositoryInterface::class),
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
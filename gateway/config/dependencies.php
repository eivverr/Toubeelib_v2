<?php

use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use toubeelib\gateway\application\actions\ConsulterPraticienByIdAction;
use toubeelib\gateway\application\actions\ConsulterPraticienRdvs;
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

    'praticiens.client' => function () {
        return new Client([
            'base_uri' => 'http://praticiens.toubeelib',
            'timeout' => 2.0,
        ]);
    },

    'rdvs.client' => function () {
        return new Client([
            'base_uri' => 'http://rdvs.toubeelib',
            'timeout' => 2.0,
        ]);
    },

    HomeAction::class => function (ContainerInterface $c) {
        return new HomeAction(
            $c->get('praticiens.client')
        );
    },

    // ### Praticiens Actions ###

    ConsulterPraticiensAction::class => function (ContainerInterface $c) {
        return new ConsulterPraticiensAction(
            $c->get('praticiens.client')
        );
    },

    ConsulterPraticienByIdAction::class => function (ContainerInterface $c) {
        return new ConsulterPraticienByIdAction(
            $c->get('praticiens.client')
        );
    },

    ConsulterPraticienRdvs::class => function (ContainerInterface $c) {
        return new ConsulterPraticienRdvs(
            $c->get('praticiens.client')
        );
    },

    GenericGetPraticienAction::class => function (ContainerInterface $c) {
        return new GenericGetPraticienAction(
            $c->get('praticiens.client')
        );
    },

    // ### Rdvs Actions ###


];
<?php

use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use toubeelib\gateway\application\actions\ConsulterPraticienByIdAction;
use toubeelib\gateway\application\actions\ConsulterPraticienRdvs;
use toubeelib\gateway\application\actions\ConsulterPraticiensAction;
use toubeelib\gateway\application\actions\GenericGetPraticienAction;
use toubeelib\gateway\application\actions\GenericGetRdvsAction;
use toubeelib\gateway\application\actions\HomeAction;
use toubeelib\gateway\application\actions\RefreshTokenAction;
use toubeelib\gateway\application\actions\RegisterAction;
use toubeelib\gateway\application\actions\SignInAction;

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

    'auth.client' => function () {
        return new Client([
            'base_uri' => 'http://auth.toubeelib',
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

    GenericGetRdvsAction::class => function (ContainerInterface $c) {
        return new GenericGetRdvsAction(
            $c->get('rdvs.client')
        );
    },

    // ### Auth Actions ###

    SignInAction::class => function (ContainerInterface $c) {
        return new SignInAction(
            $c->get('auth.client')
        );
    },

    RegisterAction::class => function (ContainerInterface $c) {
        return new \toubeelib\gateway\application\actions\RegisterAction(
            $c->get('auth.client')
        );
    },

    RefreshTokenAction::class => function (ContainerInterface $c) {
        return new \toubeelib\gateway\application\actions\RefreshTokenAction(
            $c->get('auth.client')
        );
    },


];
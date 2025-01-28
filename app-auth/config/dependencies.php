<?php

use Psr\Container\ContainerInterface;
use toubeelib\app\auth\core\services\auth\AuthService;
use toubeelib\app\auth\providers\auth\AuthProviderInterface;
use toubeelib\app\auth\providers\auth\JWTAuthProvider;

return [

    \toubeelib\application\providers\auth\JWTManager::class => function(ContainerInterface $container) {
        return new \toubeelib\application\providers\auth\JWTManager();
    },

    \toubeelib\app\auth\core\services\auth\AuthService::class => function(ContainerInterface $container) {
        return new AuthService($container->get(\toubeelib\app\auth\core\repositoryInterfaces\UserRepositoryInterface::class));
    },

    AuthProviderInterface::class => function(ContainerInterface $container) {
        return new JWTAuthProvider($container->get(\toubeelib\application\providers\auth\JWTManager::class), $container->get(AuthService::class));
    },

    // #####################
    //      Actions
    // #####################

    \toubeelib\app\auth\application\actions\PostSigninAction::class => function(ContainerInterface $container) {
        return new \toubeelib\app\auth\application\actions\PostSigninAction($container->get(AuthProviderInterface::class));
    },

    \toubeelib\app\auth\application\actions\PostRegisterAction::class => function (ContainerInterface $container) {
        return new \toubeelib\app\auth\application\actions\PostRegisterAction($container->get(AuthProviderInterface::class));
    },

    \toubeelib\app\auth\application\actions\PostRefreshAction::class => function (ContainerInterface $container) {
        return new \toubeelib\app\auth\application\actions\PostRefreshAction($container->get(AuthProviderInterface::class));
    },


];
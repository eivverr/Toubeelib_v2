<?php

use Psr\Container\ContainerInterface;
use toubeelib\app\auth\core\repositoryInterfaces\UserRepositoryInterface;
use toubeelib\app\auth\core\services\auth\AuthService;
use toubeelib\app\auth\core\services\auth\AuthServiceInterface;
use toubeelib\app\auth\infrastructure\repositories\PDOUserRepository;
use toubeelib\app\auth\application\providers\auth\AuthProviderInterface;
use toubeelib\app\auth\application\providers\auth\JWTAuthProvider;
use toubeelib\app\auth\application\providers\auth\JWTManager;

return [

    JWTManager::class => function(ContainerInterface $container) {
        return new JWTManager();
    },

    UserRepositoryInterface::class => function(ContainerInterface $container) {
        return $container->get(PDOUserRepository::class);
    },

    AuthServiceInterface::class => function(ContainerInterface $container) {
        return new AuthService(
            $container->get(UserRepositoryInterface::class)
        );
    },

    AuthProviderInterface::class => function(ContainerInterface $container) {
        return new JWTAuthProvider(
            $container->get(JWTManager::class),
            $container->get(AuthServiceInterface::class)
        );
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
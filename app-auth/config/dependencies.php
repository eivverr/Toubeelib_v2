<?php

use Psr\Container\ContainerInterface;

return [

    // #####################
    //      Actions
    // #####################

    'PostSigninAction' => function(ContainerInterface $container) {
        return new \toubeelib\app\auth\application\actions\PostSigninAction($container);
    },

    'PostRegisterAction' => function(ContainerInterface $container) {
        return new \toubeelib\app\auth\application\actions\PostRegisterAction($container);
    },

    'PostRefreshAction' => function(ContainerInterface $container) {
        return new \toubeelib\app\auth\application\actions\PostRefreshAction($container);
    },
];
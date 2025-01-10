<?php

namespace toubeelib\gateway\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\gateway\application\actions\AbstractGatewayAction;

class HomeAction extends AbstractGatewayAction
{
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $rs->getBody()->write("Hello, world!");
        return $rs;
    }
}
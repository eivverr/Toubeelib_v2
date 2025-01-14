<?php

namespace toubeelib\gateway\application\actions;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeAction extends AbstractGatewayAction
{
    private ClientInterface $remote_home_service;

    public function __construct(ClientInterface $client)
    {
        $this->remote_home_service = $client;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        return $this->remote_home_service->get("/");
    }
}
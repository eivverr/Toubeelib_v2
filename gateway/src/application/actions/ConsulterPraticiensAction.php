<?php

namespace toubeelib\gateway\application\actions;

use Psr\Http\Client\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

class ConsulterPraticiensAction extends AbstractGatewayAction
{
    private ClientInterface $remote_praticien_service;

    public function __construct(ClientInterface $client)
    {
        $this->remote_praticien_service = $client;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $response = $this->remote_praticien_service->get("/praticiens");
        } catch (ClientException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

        return $response;
    }
}
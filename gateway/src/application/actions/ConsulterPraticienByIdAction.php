<?php

namespace toubeelib\gateway\application\actions;

use Psr\Http\Client\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

class ConsulterPraticienByIdAction extends AbstractGatewayAction
{
    private ClientInterface $remote_praticien_service;

    public function __construct(ClientInterface $client)
    {
        $this->remote_praticien_service = $client;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['id'];
        try {
            $response = $this->remote_praticien_service->get("/praticiens/$id");
        } catch (ClientException $e) {
            throw new HttpNotFoundException($rq, "Praticien with id '$id' not found");
        }

        return $response;
    }
}
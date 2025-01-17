<?php

namespace toubeelib\gateway\application\actions;

use GuzzleHttp\Exception\ClientException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

class ConsulterPraticienRdvs extends AbstractGatewayAction
{
    private ClientInterface $remote_praticien_service;

    public function __construct(ClientInterface $client)
    {
        $this->remote_praticien_service = $client;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['id'];
        $data = $rq->getQueryParams();
        try {
            $date_debut = new \DateTime($data['date_debut']);
            $date_fin = new \DateTime($data['date_fin']);
            $query = ['date_debut' => $date_debut->format('Y-m-d'), 'date_fin' => $date_fin->format('Y-m-d')];
            $response = $this->remote_praticien_service->get("/praticiens/$id/dispo", ['query' => $query]);
        } catch (ClientException $e) {
            throw new HttpNotFoundException($rq, "Praticien with id '$id' not found");
        }

        return $response;
    }
}
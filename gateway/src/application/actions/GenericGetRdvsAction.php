<?php

namespace toubeelib\gateway\application\actions;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;
use toubeelib\gateway\application\actions\AbstractGatewayAction;

class GenericGetRdvsAction extends AbstractGatewayAction
{
    private ClientInterface $remote_service;

    public function __construct(ClientInterface $client)
    {
        $this->remote_service = $client;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $method = $rq->getMethod();
        $path = $rq->getUri()->getPath();
        $options = ['query' => $rq->getQueryParams()];
        if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
            $options['json'] = $rq->getParsedBody();
        }
        $auth = $rq->getHeader('Authorization') ?? null;
        if (!empty($auth)) {
            $options['headers'] = ['Authorization' => $auth];
        }
        try {
            return $this->remote_service->request($method, $path, $options);
        } catch (ConnectException | ServerException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (ClientException $e ) {
            match($e->getCode()) {
                401 => throw new HttpUnauthorizedException($rq, $e->getMessage()),
                403 => throw new HttpForbiddenException($rq, $e->getMessage()),
                404 => throw new HttpNotFoundException($rq, $e->getMessage())
            };
        }
    }
}
<?php

namespace toubeelib\gateway\application\actions;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use toubeelib\gateway\application\actions\AbstractGatewayAction;

class SignInAction extends AbstractGatewayAction
{
    private ClientInterface $authService;

    public function __construct(ClientInterface $container)
    {
        $this->authService = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $data = $rq->getParsedBody();
            $response = $this->authService->post('/signin', ['json' => $data]);
            return $response;
        } catch (ClientException $e) {
            throw new HttpNotFoundException($rq, "User not found");
        }
    }
}
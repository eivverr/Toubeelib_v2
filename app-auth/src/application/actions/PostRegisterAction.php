<?php

namespace toubeelib\app\auth\application\actions;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\app\auth\providers\auth\AuthProviderInterface;

class PostRegisterAction extends AbstractAction
{

    private AuthProviderInterface $authProvider;

    public function __construct(AuthProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        $client = new Client();
        $response = $client->post('http://localhost:8080/register', [
            'json' => [
                'email' => $email,
                'password' => $password
            ]
        ]);

        $rs->getBody()->write($response->getBody());

        return $rs->withHeader('Content-Type', 'application/json')->withStatus($response->getStatusCode());
    }
}
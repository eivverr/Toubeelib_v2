<?php

namespace toubeelib\app\auth\application\actions;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\app\auth\application\providers\auth\AuthProviderInterface;
use toubeelib\app\auth\core\dto\CredentialsDTO;

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

        $credentialsDTO = new CredentialsDTO($email, $password);

        $this->authProvider->register($credentialsDTO, 3);

        $rs->getBody()->write(json_encode([
            'message' => 'User registered successfully'
        ]));

        return $rs->withHeader('Content-Type', 'application/json')->withStatus($rs->getStatusCode());
    }
}
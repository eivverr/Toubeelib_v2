<?php

namespace toubeelib\app\auth\application\actions;

use PhpParser\Token;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\app\auth\application\actions\AbstractAction;
use toubeelib\app\auth\application\providers\auth\AuthProviderInterface;

class GetValidateTokenAction extends AbstractAction
{

    private AuthProviderInterface $authProvider;

    public function __construct(AuthProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $authorizationHeader = $rq->getHeader('Authorization');
        if (empty($authorizationHeader) || !preg_match('/Bearer\s(\S+)/', $authorizationHeader[0], $matches)) {
            return $rs->withStatus(401, 'Authorization header missing or malformed');
        }

        $token = $matches[1];

        try {
            $authDTO = $this->authProvider->getSignedInUser($token);
            if ($authDTO->getId() == null) {
                throw new \Exception('Invalid token');
            }
        } catch (\Exception $e) {
            return $rs->withStatus(401, 'Unauthorized: ' . $e->getMessage());
        }

        return $rs->withStatus(200);
    }
}
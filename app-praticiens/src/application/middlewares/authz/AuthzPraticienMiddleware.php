<?php

namespace toubeelib\app\praticiens\middlewares\authz;

use toubeelib\app\praticiens\core\services\authorization\AuthzPraticienServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;

class AuthzPraticienMiddleware
{
    private AuthzPraticienServiceInterface $authzPraticienService;

    public function __construct(AuthzPraticienServiceInterface $authzPraticienService)
    {
        $this->authzPraticienService = $authzPraticienService;
    }

    public function __invoke() : Response
    {
        // TODO: Implement __invoke() method.
    }
}
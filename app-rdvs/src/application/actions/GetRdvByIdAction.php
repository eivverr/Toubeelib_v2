<?php

namespace toubeelib\app\rdvs\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use toubeelib\app\rdvs\application\actions\AbstractAction;
use toubeelib\app\rdvs\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\app\rdvs\core\services\rdv\ServiceRdvInterface;
use toubeelib\app\rdvs\core\services\rdv\ServiceRdvInvalidDataException;
use toubeelib\app\rdvs\infrastructure\repositories\PDOPraticienRepository;

class GetRdvByIdAction extends AbstractAction
{
    private ServiceRdvInterface $rdv_service;

    public function __construct(ServiceRdvInterface $rdv_service)
    {
        $this->rdv_service = $rdv_service;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['id'];

        try {
            $rdv = $this->rdv_service->getRdvById($id);
        } catch(ServiceRdvInvalidDataException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        }

        $data = ['type' => 'ressource', 'rdv' => $rdv];
        $rs->getBody()->write(json_encode($data));
//        return JsonRenderer::render($rs, 200, $data);
        return $rs
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
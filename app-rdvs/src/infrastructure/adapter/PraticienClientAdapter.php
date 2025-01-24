<?php

namespace toubeelib\app\rdvs\infrastructure\adapter;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use PHPUnit\Framework\Exception;
use Psr\Http\Client\ClientInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;
use toubeelib\app\rdvs\core\dto\PraticienDTO;
use toubeelib\app\rdvs\core\services\praticien\ServicePraticienInterface;

class PraticienClientAdapter implements ServicePraticienInterface
{
    private ClientInterface $remote;

    public function __construct(ClientInterface $remote)
    {
        $this->remote = $remote;
    }

    public function getPraticienById(string $id): PraticienDTO
    {
        try {
            $response = $this->remote->request('GET', '/praticiens/' . $id);
            $response_data = json_decode((string)$response->getBody(), true);
            return new PraticienDTO($response_data['product']);
        } catch (ConnectException | ServerException $e) {
            throw new Exception($e->getMessage());
        } catch (ClientException $e ) {
            match($e->getCode()) {
                404 => throw new HttpNotFoundException($e->getMessage()),
                403 => throw new HttpForbiddenException($e->getMessage()),
            };
        }
    }
}
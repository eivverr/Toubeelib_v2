<?php

namespace toubeelib\gateway\application\middlewares;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class AuthMiddleware
{
    private $authServiceUrl;
    private $client;

    public function __construct(string $authServiceUrl)
    {
        $this->authServiceUrl = $authServiceUrl;
        $this->client = new Client();
    }

    public function __invoke(Request $rq, RequestHandlerInterface $handler): Response
    {
        try {
            $token = $rq->getHeaderLine('Authorization');
            if (empty($token) || !preg_match('/Bearer\s(\S+)/', $token, $matches)) {
                return (new Response())->withStatus(401);
            }

            $tokenstring = $matches[1];

            $response = $this->client->get($this->authServiceUrl . '/tokens/validate', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $tokenstring,
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $authData = json_decode($response->getBody()->getContents(), true);
                $rq = $rq->withAttribute('auth', $authData['user']);

                return $handler->handle($rq);
            } else {
                return (new Response())->withStatus(401);
            }
        } catch (RequestException|\Exception $e) {
            return (new Response())->withStatus(401);
        }
    }
}

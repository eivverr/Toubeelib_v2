<?php

namespace toubeelib\gateway\application\middlewares;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;

class AuthMiddleware
{
    private ClientInterface $remoteAuthService;

    public function __construct(ClientInterface $client)
    {
        $this->remoteAuthService = $client;
    }

    public function __invoke(Request $rq, RequestHandlerInterface $handler): \Psr\Http\Message\ResponseInterface
    {
        try {
            $token = $rq->getHeaderLine('Authorization');
            if (empty($token) || !preg_match('/Bearer\s(\S+)/', $token, $matches)) {
                return (new Response())->withStatus(401);
            }

            $tokenstring = $matches[1];

            $response = $this->remoteAuthService->get('/tokens/validate', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $tokenstring,
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                return $handler->handle($rq);
            } else {
                return (new Response())->withStatus(401);
            }
        } catch (RequestException|\Exception $e) {
            return (new Response())->withStatus(401, $e->getMessage());
        } catch (GuzzleException $e) {
            return (new Response())->withStatus(502, 'Bad Gateway');
        }
    }
}

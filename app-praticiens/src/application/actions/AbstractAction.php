<?php

namespace toubeelib\app\praticiens\application\actions;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAction
{


    abstract public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface ;

}
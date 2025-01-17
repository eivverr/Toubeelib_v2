<?php

namespace toubeelib\app\praticiens\core\services\authorization;

interface AuthzPraticienServiceInterface
{
    public function isGranted(string $user_id, int $role, int $operation, string $ressource_id): bool;
}
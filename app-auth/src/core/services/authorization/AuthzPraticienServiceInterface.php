<?php

namespace toubeelib\app\auth\core\services\authorization;

interface AuthzPraticienServiceInterface
{
    public function isGranted(string $user_id, int $role, int $operation, string $ressource_id): bool;
}
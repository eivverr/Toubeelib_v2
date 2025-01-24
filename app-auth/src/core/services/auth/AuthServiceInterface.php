<?php

namespace toubeelib\app\auth\core\services\auth;

use toubeelib\app\auth\core\dto\AuthDTO;
use toubeelib\app\auth\core\dto\CredentialsDTO;

interface AuthServiceInterface
{
    public function createUser(CredentialsDTO $credentials, int $role): string;
    public function byCredentials(CredentialsDTO $credentials): AuthDTO;
}
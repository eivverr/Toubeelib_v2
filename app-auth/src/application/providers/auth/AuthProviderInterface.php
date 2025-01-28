<?php

namespace toubeelib\app\auth\application\providers\auth;

use PhpParser\Token;
use toubeelib\app\auth\core\dto\AuthDTO;
use toubeelib\app\auth\core\dto\CredentialsDTO;

interface AuthProviderInterface
{
    public function register(CredentialsDTO $credentials, int $role): void;
    public function signin(CredentialsDTO $credentials): AuthDTO;
    public function refresh(Token $token): AuthDTO;
    public function getSignedInUser(Token $token): AuthDTO;
}
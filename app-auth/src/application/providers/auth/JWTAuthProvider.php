<?php

namespace toubeelib\app\auth\application\providers\auth;

use PhpParser\Token;
use toubeelib\app\auth\core\domain\entities\User;
use toubeelib\app\auth\core\dto\AuthDTO;
use toubeelib\app\auth\core\dto\CredentialsDTO;
use toubeelib\app\auth\core\services\auth\AuthServiceInterface;

class JWTAuthProvider implements AuthProviderInterface
{
    private JWTManager $jwtManager;
    private AuthServiceInterface $authService;

    public function __construct(JWTManager $jwtManager, AuthServiceInterface $authService)
    {
        $this->jwtManager = $jwtManager;
        $this->authService = $authService;
    }

    public function register(CredentialsDTO $credentials, int $role): void
    {
        $this->authService->createUser($credentials, $role);
    }

    public function signin(CredentialsDTO $credentials): AuthDTO
    {
        $authDTO = $this->authService->byCredentials($credentials);
        $authDTO->setToken($this->jwtManager->createAccessToken([
            'id' => $authDTO->getId(),
            'email' => $authDTO->getEmail(),
            'role' => $authDTO->getRole()
        ]));
        $authDTO->setRefreshToken($this->jwtManager->createRefreshToken([
            'id' => $authDTO->getId(),
            'email' => $authDTO->getEmail(),
            'role' => $authDTO->getRole()
        ]));
        return $authDTO;
    }

    public function refresh(string $token): AuthDTO
    {
        // TODO: Implement refresh() method.
    }

    public function getSignedInUser(string $token): AuthDTO
    {
        $decodedToken = $this->jwtManager->decodeToken($token);

        if (empty($decodedToken['id']) || empty($decodedToken['email']) || empty($decodedToken['role'])) {
            throw new \Exception('Invalid token data');
        }

        $id = $decodedToken['id'];
        $email = $decodedToken['email'];
        $role = $decodedToken['role'];

        $user = new User($email, $role);
        $user->setId($id);

        return new AuthDTO($user);
    }
}
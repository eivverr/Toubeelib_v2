<?php

namespace toubeelib\app\auth\core\services\auth;

use Ramsey\Uuid\Uuid;
use toubeelib\app\auth\core\domain\entities\User;
use toubeelib\app\auth\core\dto\AuthDTO;
use toubeelib\app\auth\core\dto\CredentialsDTO;
use toubeelib\app\auth\core\repositoryInterfaces\UserRepositoryInterface;
use toubeelib\app\auth\core\services\auth\AuthServiceInterface;

class AuthService implements AuthServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(CredentialsDTO $credentials, int $role): string
    {
        $user = new User($credentials->getEmail(),password_hash($credentials->getPassword(), PASSWORD_DEFAULT) , $role);
        $user->setId(Uuid::uuid4()->toString());
        return $this->userRepository->save($user);
    }

    public function byCredentials(CredentialsDTO $credentials): AuthDTO
    {
        $user = $this->userRepository->getUserByEmail($credentials->getEmail());
        if ($user && password_verify($credentials->getPassword(), $user->getPassword())) {
            return new AuthDTO($user);
        } else {
            throw new AuthServiceBadDataException('Erreur 400 : Email ou mot de passe incorrect', 400);
        }
    }
}
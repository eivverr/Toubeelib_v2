<?php

namespace toubeelib\app\auth\core\repositoryInterfaces;

use toubeelib\app\auth\core\domain\entities\User;

interface UserRepositoryInterface
{
    public function getUserById(string $id): User;
    public function save(User $user): string;
    public function getUserByEmail(string $email): User;
}
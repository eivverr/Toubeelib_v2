<?php

namespace toubeelib\app\auth\infrastructure\repositories;

use PDO;
use PDOException;
use toubeelib\app\auth\core\domain\entities\User;
use toubeelib\app\auth\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\app\auth\core\repositoryInterfaces\UserRepositoryInterface;

class PDOUserRepository implements UserRepositoryInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $dbCredentials = parse_ini_file(__DIR__ . '/../../../config/toubeelibdb.env');
        try {
            $this->pdo = new PDO(
                'pgsql:host=toubeelib.db;dbname=toubeelib',
                $dbCredentials['POSTGRES_USER'],
                $dbCredentials['POSTGRES_PASSWORD'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            throw new \RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }

    public function getUserById(string $id): User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM USERS WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $PDOuser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$PDOuser) {
            throw new RepositoryEntityNotFoundException('User not found');
        }

        return $this->hydrateUser($PDOuser);
    }

    public function save(User $user): string
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO USERS (id, email, password, role) 
             VALUES (:id, :email, :password, :role) 
             ON CONFLICT (id) 
             DO UPDATE SET email = EXCLUDED.email, password = EXCLUDED.password, role = EXCLUDED.role'
        );
        $stmt->execute([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole()
        ]);

        return $user->getId();
    }

    public function getUserByEmail(string $email): User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM USERS WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $PDOuser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$PDOuser) {
            throw new RepositoryEntityNotFoundException('User not found');
        }

        return $this->hydrateUser($PDOuser);
    }

    private function hydrateUser(array $data): User
    {
        $user = new User($data['email'], $data['role']);
        $user->setPassword($data['password']);
        $user->setId($data['id']);
        return $user;
    }
}
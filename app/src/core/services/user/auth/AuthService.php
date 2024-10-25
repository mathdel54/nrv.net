<?php

namespace nrv\core\services\user\auth;

use DateTime;
use nrv\core\dto\auth\AuthDTO;
use nrv\core\dto\auth\CredentialsDTO;
use InvalidArgumentException;
use nrv\core\domain\entities\users\Users;
use nrv\core\repositoryInterface\UsersRepositoryInterface;

class AuthService implements AuthServiceInterface
{
    private UsersRepositoryInterface $userRepository;

    public function __construct(UsersRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function verifyCredentials(string $email, string $password): AuthDTO
    {
        $user = $this->userRepository->findByEmail($email);
    
        if (!$user || !password_verify($password, $user->password)) {
            throw new InvalidArgumentException('Invalid credentials');
        }
    
        return new AuthDTO(
            $user->getId(),
            $user->email,
            $user->role, // Utilisez le rôle de l'utilisateur, pas le mot de passe
            '', // accessToken vide ici
            ''  // refreshToken vide ici
        );
    }
    

    public function registerUser(string $nom, string $prenom, CredentialsDTO $credentialsDTO, int $role): void
    {
        $existingUser = $this->userRepository->findByEmail($credentialsDTO->email);
        if ($existingUser) {
            throw new InvalidArgumentException('Un compte avec cette adresse existe déjà');
        }
    
        $hashedPassword = password_hash($credentialsDTO->password, PASSWORD_BCRYPT);
        $user = new Users($nom, $prenom, $credentialsDTO->email, $hashedPassword, $role); // Utiliser $hashedPassword ici
    
        $this->userRepository->save($user);
    }
    
    public function getUserById(int $userId): AuthDTO
    {
        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw new InvalidArgumentException('User not found');
        }

        return new AuthDTO(
            $user->getId(),
            $user->email,
            $user->role,
            '', // Access token
            ''  // Refresh token
        );
    }

}

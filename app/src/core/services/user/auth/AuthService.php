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
        
        if (!$user) {
            error_log("Authentication failed for email: $email - User not found");
            throw new InvalidArgumentException('Invalid credentials');
        }

        try {
            if (!password_verify($password, $user->password)) {
                error_log("Authentication failed for email: $email - Incorrect password");
                throw new InvalidArgumentException('Invalid credentials'); 
            }
        }  catch (InvalidArgumentException $e) {
            
        }   
    
        return new AuthDTO(
            $user->getId(),
            $user->email,
            $user->role,
            '', // Access token not generated yet
            ''  // Refresh token not generated yet
        );
    }
    

    public function registerUser(string $nom, string $prenom, CredentialsDTO $credentialsDTO, string $pwdConfirmation,  int $role): void
    {
        $existingUser = $this->userRepository->findByEmail($credentialsDTO->email);
        if ($existingUser) {
            throw new InvalidArgumentException('Un compte avec cette adresse existe déjà');
        }
        if ($credentialsDTO->password !== $pwdConfirmation) {
            throw new InvalidArgumentException('les mots de passes ne sont pas identiques');
        }
        $hashedPassword = password_hash($credentialsDTO->password, PASSWORD_BCRYPT);
        $user = new Users($nom, $prenom, $credentialsDTO->email, $hashedPassword, $role); 
    
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
            '', 
            ''  
        );
    }

}

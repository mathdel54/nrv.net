<?php

namespace nrv\core\services\auth;

use nrv\core\dto\auth\AuthDTO;
use InvalidArgumentException;
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

        if (!$user || !password_verify($password, $user->pass)) {
            throw new InvalidArgumentException('Invalid credentials');
        }

        return new AuthDTO(
            $user->getId(),
            $user->email,
            $user->pass,
            '',
            ''  
        );
    }
}

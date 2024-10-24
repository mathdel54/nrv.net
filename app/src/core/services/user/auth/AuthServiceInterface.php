<?php

namespace nrv\core\services\user\auth;

use DateTime;
use nrv\core\dto\auth\AuthDTO;
use nrv\core\dto\auth\CredentialsDTO;

interface AuthServiceInterface
{
    public function verifyCredentials(string $email, string $password): AuthDTO;
    public function registerUser(string $nom, string $prenom, DateTime $dateNaissance, CredentialsDTO $credentialsDTO, int $role): void;
    public function getUserById(int $userId): AuthDTO;
}

<?php

namespace nrv\core\services\auth;

use nrv\core\dto\auth\AuthDTO;

interface AuthServiceInterface
{
    /**
     * Vérifie les identifiants de l'utilisateur (email et mot de passe).
     *
     * @param string $email L'email de l'utilisateur.
     * @param string $password Le mot de passe de l'utilisateur.
     * @return AuthDTO Renvoie un DTO contenant les informations d'authentification de l'utilisateur.
     * @throws \InvalidArgumentException Si les identifiants sont incorrects.
     */
    public function verifyCredentials(string $email, string $password): AuthDTO;
}

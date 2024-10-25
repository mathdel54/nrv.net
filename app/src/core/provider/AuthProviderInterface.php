<?php

namespace nrv\core\provider;

use DateTime;
use nrv\core\dto\auth\AuthDTO;
use nrv\core\dto\auth\CredentialsDTO;
use PhpParser\Token;

interface AuthProviderInterface
{
    public function register(string $nom, string $prenom, CredentialsDTO $credentialsDTO, int $role): void;
    public function authenticate(CredentialsDTO $credentialsDTO):AuthDTO;
    public function refreshToken(Token $token):AuthDTO;
    public function getSigninUser(Token $token):AuthDTO;
}
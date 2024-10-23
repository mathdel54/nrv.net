<?php

namespace nrv\core\provider;

use nrv\core\services\auth\AuthServiceInterface;
use nrv\core\dto\auth\AuthDTO;
use nrv\core\dto\auth\CredentialsDTO;
use PhpParser\Token;

interface AuthProviderInterface
{
    public function register(CredentialsDTO $credentialsDTO, int $role):void;
    public function signin(CredentialsDTO $credentialsDTO):AuthDTO;
    public function refreshToken(Token $token):AuthDTO;
    public function getSigninUser(Token $token):AuthDTO;
}
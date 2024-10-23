<?php

namespace nrv\core\provider;

use nrv\core\services\auth\AuthServiceInterface;
use nrv\core\dto\auth\AuthDTO;
use nrv\core\provider\AuthProviderInterface;
use Firebase\JWT\JWT;
use DateTimeImmutable;

class AuthProvider implements AuthProviderInterface
{
    private AuthServiceInterface $authService;
    private string $jwtSecret;

    public function __construct(AuthServiceInterface $authService, string $jwtSecret)
    {
        $this->authService = $authService;
        $this->jwtSecret = $jwtSecret;
    }

    public function signin(string $email, string $password): AuthDTO
    {
        $authDTO = $this->authService->verifyCredentials($email, $password);

        $issuedAt = new DateTimeImmutable();
        $expire = $issuedAt->modify('+1 hour')->getTimestamp();
        $serverName = "nrv.com";

        $data = [
            'iat'  => $issuedAt->getTimestamp(),
            'iss'  => $serverName,
            'nbf'  => $issuedAt->getTimestamp(),
            'exp'  => $expire,
            'userId' => $authDTO->ID,
            'role' => $authDTO->role,
        ];

        $accessToken = JWT::encode($data, $this->jwtSecret, 'HS256');
        $refreshToken = JWT::encode($data, $this->jwtSecret, 'HS256');

        $authDTO->setAccessToken($accessToken);
        $authDTO->setRefreshToken($refreshToken);

        return $authDTO;
    }
}

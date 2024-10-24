<?php

namespace nrv\core\provider;

use nrv\core\services\user\auth\AuthServiceInterface;
use nrv\core\dto\auth\AuthDTO;
use nrv\core\dto\auth\CredentialsDTO;
use nrv\core\provider\AuthProviderInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTime;
use DateTimeImmutable;
use Exception;
use PhpParser\Token;

class JWTAuthProvider implements AuthProviderInterface
{
    private AuthServiceInterface $authService;
    private string $jwtSecret;

    public function __construct(AuthServiceInterface $authService, string $jwtSecret)
    {
        $this->authService = $authService;
        $this->jwtSecret = $jwtSecret;
    }

    public function register(string $nom, string $prenom, CredentialsDTO $credentialsDTO, int $role): void
    {
        $authDTO = $this->authService->verifyCredentials($credentialsDTO->email, $credentialsDTO->password);
        $this->authService->registerUser($nom, $prenom, $credentialsDTO, $role);
    }

    public function authenticate(CredentialsDTO $credentialsDTO): AuthDTO
    {
        $authDTO = $this->authService->verifyCredentials($credentialsDTO->email, $credentialsDTO->password);

        $issuedAt = new DateTimeImmutable();
        $expire = $issuedAt->modify('+1 hour')->getTimestamp();
        $serverName = "nrv.com";

        $data = [
            'iat'  => $issuedAt->getTimestamp(),
            'iss'  => $serverName,
            'nbf'  => $issuedAt->getTimestamp(),
            'exp'  => $expire,
            'userId' => $authDTO->id,
            'role' => $authDTO->role,
        ];

        $accessToken = JWT::encode($data, $this->jwtSecret, 'HS256');
        $refreshToken = JWT::encode($data, $this->jwtSecret, 'HS256');

        $authDTO->setAccessToken($accessToken);
        $authDTO->setRefreshToken($refreshToken);

        return $authDTO;
    }

    public function refreshToken(Token $refreshToken): AuthDTO
    {
        try {
            $decode = JWT::decode($refreshToken, new Key($this->jwtSecret, 'HS256'));

            $issuedAt = new DateTimeImmutable();
            $expire = $issuedAt->modify('+1 hour')->getTimestamp();
            $serverName = "nrv.com";

            $data = [
                'iat' => $issuedAt->getTimestamp(),
                'iss' => $serverName,
                'nbf' => $issuedAt->getTimestamp(),
                'exp' => $expire,
                'userId' => $decode->userId,
                'role' => $decode->role,
            ];

            $newAccessToken = JWT::encode($data, $this->jwtSecret, 'HS256');

            $authDTO = $this->authService->getUserById($decode->userId);
            $authDTO->setAccessToken($newAccessToken);
            $authDTO->setRefreshToken($refreshToken);

            return $authDTO;
        } catch (Exception $e) {
            throw new Exception('Invalid refresh token: ' . $e->getMessage());
        }
    }

    public function getSigninUser(Token $accessToken): AuthDTO
    {
        try {
            $decode = JWT::decode($accessToken, new Key($this->jwtSecret, 'HS256'));

            $authDTO = $this->authService->getUserById($decode->userId);

            return $authDTO;
        } catch (Exception $e) {
            throw new Exception('Invalid access token: ' . $e->getMessage());
        }
    }
}

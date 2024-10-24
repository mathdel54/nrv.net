<?php

namespace nrv\core\dto\auth;

use nrv\core\dto\DTO;

class AuthDTO extends DTO
{
    protected string $id;
    protected string $email;
    protected int $role;
    protected string $accessToken;
    protected string $refreshToken;

    public function __construct(string $id, string $email, int $role, string $accessToken, string $refreshToken)
    {
        $this->id = $id;
        $this->email = $email;
        $this->role = $role;
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    

    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    public function getAccessToken():string
    {
        return $this->accessToken;
    }

    public function getRefreshToken():string
    {
        return $this->refreshToken;
    }
}

<?php

namespace nrv\core\dto\auth;

use nrv\core\dto\DTO;

class CredentialsDTO extends DTO
{
    protected string $email;
    protected string $password;

    /**
     * Constructor
     *
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function json_serialize(): string
    {
        $credentialsArray = 
        [
            'email' => $this->email,
            'password' => $this->password
        ];

        return json_encode($credentialsArray);
    }

}

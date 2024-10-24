<?php

namespace nrv\core\dto\users;

use DateTime;
use nrv\core\dto\DTO;


class UsersDTO extends DTO
{
    protected string $ID;
    protected string $nom;
    protected string $prenom;
    protected string $email;
    protected string $password;
    protected int $role;

    public function __construct(string $ID, string $nom, string $prenom, string $email, string $password, int $role)
    {
        $this->ID = $ID;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
    }

}
<?php

namespace nrv\core\domain\entities\users;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\users\UsersDTO;

class Users extends Entity
{
    protected string $nom;
    protected string $prenom;
    protected string $email;
    protected string $password;
    protected int $role;

    public function __construct(string $nom, string $prenom,string $email, string $password, int $role)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
    }

    public function toDTO() : UsersDTO
    {
        return new UsersDTO($this->ID, $this->nom, $this->prenom, $this->email, $this->password,$this->role );
    }
}
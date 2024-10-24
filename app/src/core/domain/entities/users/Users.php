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
    protected DateTime $dateNaissance;
    protected int $role;

    public function __construct(string $nom, string $prenom, DateTime $dateNaissance, string $email, string $password, int $role)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
    }

    public function toDTO() : UsersDTO
    {
        return new UsersDTO($this->ID, $this->nom, $this->prenom, $this->dateNaissance, $this->email, $this->pass,$this->role );
    }
}
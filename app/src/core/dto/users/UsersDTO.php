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
    protected string $pass;
    protected DateTime $dateNaissance;
    protected int $role;

    public function __construct(string $ID, string $nom, string $prenom, DateTime $dateNaissance, string $email, string $pass, int $role)
    {
        $this->ID = $ID;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->email = $email;
        $this->role = $role;
        $this->pass = $pass;
    }

}
<?php

namespace nrv\core\repositoryInterface;

use nrv\core\domain\entities\users\Users;

interface UsersRepositoryInterface {
    /**
     * Trouver un patient par son email.
     *
     * @param string $email
     * @return Users|null
     */
    public function findByEmail(string $email): ?Users;

    /**
     * Trouver un patient par son ID.
     *
     * @param string $id
     * @return Users|null
     */
    public function findById(string $id): ?Users;

    /**
     * Enregistrer un patient dans le repository.
     *
     * @param Users $patient
     * @return string ID du patient
     */
    public function save(Users $patient): string;

    /**
     * Supprimer un patient à partir de son ID.
     *
     * @param string $id
     * @throws RepositoryEntityNotFoundException si le patient n'est pas trouvé
     * @return void
     */
    public function delete(string $id): void;

    /**
     * Obtenir tous les patients du repository.
     *
     * @return array Liste de patients
     */
    public function getAll(): array;
}
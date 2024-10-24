<?php

namespace nrv\infrastructure\repositories;

use nrv\core\repositoryInterface\RepositoryDatabaseErrorException;
use nrv\core\repositoryInterface\RepositoryEntityNotFoundException;
use nrv\core\domain\entities\spectacle\LieuxSpectacle;
use nrv\core\domain\entities\users\Users; 
use nrv\core\repositoryInterface\UsersRepositoryInterface; 
use Ramsey\Uuid\Uuid;

class PDOUsersRepository implements UsersRepositoryInterface
{
    private $pdoNrv;

    public function __construct($pdoNrv)
    {
        $this->pdoNrv = $pdoNrv;
    }

    /**
     * Trouver un utilisateur par son email.
     *
     * @param string $email
     * @return Users|null
     * @throws RepositoryDatabaseErrorException
     */
    public function findByEmail(string $email): ?Users
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            if (!$user) {
                return null; // Pas trouvé
            }
            return $this->mapToUser($user);
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération de l\'utilisateur par email', 0, $e);
        }
    }

    /**
     * Trouver un utilisateur par son ID.
     *
     * @param string $id
     * @return Users|null
     * @throws RepositoryDatabaseErrorException
     */
    public function findById(string $id): ?Users
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $user = $stmt->fetch();
            if (!$user) {
                return null; // Pas trouvé
            }
            return $this->mapToUser($user);
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération de l\'utilisateur par ID', 0, $e);
        }
    }

    public function save(Users $user): string
    {
        try {
            // Générer un UUID pour l'utilisateur
            $userId = Uuid::uuid4()->toString();  // Utilisation de ramsey/uuid
    
            // Préparer la requête SQL avec toutes les colonnes, y compris le rôle
            $stmt = $this->pdoNrv->prepare("
                INSERT INTO users (id, nom, prenom, email, mot_de_passe, date_enregistrement, role) 
                VALUES (:id, :nom, :prenom, :email, :motDePasse, :dateEnregistrement, :role)
            ");
            
            // Exécuter la requête avec les données de l'utilisateur
            $stmt->execute([
                'id' => $userId,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'email' => $user->email,
                'motDePasse' => password_hash($user->password, PASSWORD_DEFAULT), // Hasher le mot de passe
                'dateEnregistrement' => (new \DateTime())->format('Y-m-d H:i:s'), // Date actuelle
                'role' => $user->role // Ajouter le rôle
            ]);
    
            return $userId; // Retourner l'UUID généré
        } catch (\PDOException $e) {
            // Logger l'erreur et lancer une exception personnalisée
            error_log($e->getMessage());
            throw new RepositoryDatabaseErrorException('Erreur lors de l\'enregistrement de l\'utilisateur', 0, $e);
        }
    }
    
    /**
     * Supprimer un utilisateur à partir de son ID.
     *
     * @param string $id
     * @throws RepositoryEntityNotFoundException si l'utilisateur n'est pas trouvé
     * @throws RepositoryDatabaseErrorException
     */
    public function delete(string $id): void
    {
        try {
            if ($this->findById($id) === null) {
                throw new RepositoryEntityNotFoundException('Utilisateur non trouvé pour l\'ID : ' . $id);
            }
            $stmt = $this->pdoNrv->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la suppression de l\'utilisateur', 0, $e);
        }
    }

    /**
     * Obtenir tous les utilisateurs du repository.
     *
     * @return array Liste d'utilisateurs
     * @throws RepositoryDatabaseErrorException
     */
    public function getAll(): array
    {
        try {
            $stmt = $this->pdoNrv->query("SELECT * FROM users");
            $users = $stmt->fetchAll();
            return array_map([$this, 'mapToUser'], $users);
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des utilisateurs', 0, $e);
        }
    }

    /**
     * Mapper un tableau associatif vers un objet Users.
     *
     * @param array $userData
     * @return Users
     */
    private function mapToUser(array $userData): Users
    {
        $user = new Users($userData['nom'], $userData['prenom'],$userData['dateNaissance'], $userData['email'], $userData['password'], $userData['role']);
        $user->setID($userData['id']);
        return $user;
    }
}

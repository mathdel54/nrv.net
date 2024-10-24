<?php

namespace nrv\application\actions;

use DateTime;
use nrv\core\dto\auth\CredentialsDTO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\provider\AuthProviderInterface;
class CreerCompteAction extends AbstractAction
{
    
    protected AuthProviderInterface $authProvider;

    public function __construct(AuthProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();

        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;
        $dateNaissance = isset($data['dateNaissance']) ? new DateTime($data['dateNaissance']) : null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $role = $data['role'] ?? 1; // role par defaut des users est 1

        echo(var_dump($data));

        if (!$nom || !$prenom || !$dateNaissance || !$email || !$password) {
            $rs->getBody()->write(json_encode(['error' => 'Certains champs requis sont manquants']));
            return $rs->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $credentialsDTO = new CredentialsDTO($email, $password);

        try {
            $this->authProvider->register($nom, $prenom, $dateNaissance, $credentialsDTO, $role);
            $rs->getBody()->write(json_encode(['message' => 'Compte cree avec succes']));
            return $rs->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

    }

}

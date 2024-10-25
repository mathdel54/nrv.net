<?php

namespace nrv\application\actions;

use nrv\core\dto\auth\CredentialsDTO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\provider\AuthProviderInterface;
use Slim\Psr7\Response;

class ConnexionAction extends AbstractAction
{
    protected AuthProviderInterface $authProvider;

    public function __construct(AuthProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        // Récupérer les données de la requête (ex: email et mot de passe)
        $data = $rq->getParsedBody();

        
        if (!isset($data['email'], $data['password'])) {
            // Si les informations d'authentification sont manquantes, renvoyer une erreur
            $rs->getBody()->write(json_encode(['error' => 'Email et mot de passe requis']));
            return $rs->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        // Créer un DTO pour passer les informations d'authentification
        $credentials = new CredentialsDTO($data['email'], $data['password']);

        try {
            // Utiliser l'authProvider pour authentifier l'utilisateur
            $authResult = $this->authProvider->authenticate($credentials);

            if ($authResult) {
                // Si l'authentification réussit, renvoyer un token ou des infos de session
                $rs->getBody()->write(json_encode([
                    'message' => 'Connexion réussie',
                    'token' => $authResult->getAccessToken(),
                    'user_id' => $authResult->id
                ]));
                return $rs->withStatus(200)->withHeader('Content-Type', 'application/json');
            } else {
                // Si les identifiants sont incorrects
                $rs->getBody()->write(json_encode(['error' => 'Identifiants incorrects']));
                return $rs->withStatus(401)->withHeader('Content-Type', 'application/json');
            }
        } catch (\Exception $e) {

            $rs->getBody()->write(json_encode(['error' => 'Erreur lors de la connexion']));
            return $rs->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}

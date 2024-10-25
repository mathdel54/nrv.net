<?php

namespace nrv\application\middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpException;

class AuthMiddleware
{
    private string $jwtSecret;

    public function __construct(string $jwtSecret)
    {
        $this->jwtSecret = $jwtSecret;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $route = $request->getUri()->getPath();
        $method = $request->getMethod();

        // Définir les routes ou méthodes publiques
        $publicRoutes = ['/connexion', '/inscription', '/spectacle'];
        $isPublicRoute = in_array($route, $publicRoutes) || $method === 'OPTIONS';

        // Laisser passer les routes publiques ou OPTIONS
        if ($isPublicRoute) {
            return $handler->handle($request);
        }

        // Continuer avec l'authentification pour les autres routes
        $authHeader = $request->getHeader('Authorization');
        if (!$authHeader || empty($authHeader[0])) {
            throw new HttpException($request, "header invalide", 401);
        }

        $token = str_replace('Bearer ', '', $authHeader[0]);
        error_log('Token: ' . $token); // Ajoutez cette ligne pour afficher le token
        
        try {
            $decoded = JWT::decode($token, new Key($this->jwtSecret, 'HS256'));
            $request = $request->withAttribute('auth', $decoded);
        } catch (\Exception $e) {
            error_log('Token decoding error: ' . $e->getMessage()); // Ajoutez cette ligne
            throw new HttpException($request, "Invalid token", 403);
        }
        

        return $handler->handle($request);
    }
}

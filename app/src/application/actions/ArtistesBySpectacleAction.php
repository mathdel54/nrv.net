<?php

namespace nrv\application\actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use nrv\application\renderer\JsonRenderer;
use nrv\core\services\user\ServiceUserInterface;
use nrv\core\services\user\ServiceUserNotFoundException;

class ArtistesBySpectacleAction {
    
    protected ServiceUserInterface $serviceUser;

    public function __construct(ServiceUserInterface $serviceUser) {
        $this->serviceUser = $serviceUser;
    }

    public function __invoke (ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface {
        $id = $args['ID_Spectacle'];

        try {
            $artistes = $this->serviceUser->getArtistesBySpectacle($id);
            $data = [];
            foreach ($artistes as $artiste) {
                $data[] = [
                    'nom' => $artiste->nom,
                    'links' => [
                        'self' => [ 'href' => '/spectacles/' . $id . '/artistes']
                    ]
                ];
            }
            
        } catch (ServiceUserNotFoundException $e) {
            $data = [
                 'message' => $e->getMessage(),
                 'exception' => [
                     'type' => get_class($e),
                     'code' => $e->getCode(),
                     'file' => $e->getFile(),
                     'line' => $e->getLine()
                 ]
             ];
             return JsonRenderer::render($rs, 404, $data);
         } catch (\Exception  $e) {
             $data = [
                 'message' => $e->getMessage(),
                 'exception' => [
                     'type' => get_class($e),
                     'code' => $e->getCode(),
                     'file' => $e->getFile(),
                     'line' => $e->getLine()
                 ]
             ];
             return JsonRenderer::render($rs, 400, $data);
         }

         // On rajoute les liens HATEOAS
         $tabFinal = [
            'type' => 'ressource',
            'locale' => 'fr_FR',
            'artistes' => $data,
            'links' => [
                'spectacles' => [ 'href' => '/spectacles']
            ]
        ];

        return JsonRenderer::render($rs, 200, $tabFinal);

    }
}
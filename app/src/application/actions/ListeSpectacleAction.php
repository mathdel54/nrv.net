<?php

namespace nrv\application\actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use nrv\application\renderer\JsonRenderer;
use nrv\core\services\ServiceUserInterface;
use nrv\core\services\ServiceUserNotFoundException;

class ListeSpectacleAction {
    
    protected ServiceUserInterface $serviceUser;

    public function __construct(ServiceUserInterface $serviceUser) {
        $this->serviceUser = $serviceUser;
    }

    public function __invoke (ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface {
        try {
            $spectacles = $this->serviceUser->getSpectacles();
            $data = [];
            foreach ($spectacles as $spectacle) {
                $data[] = [
                    'titre' => $spectacle->titre,
                    'date' => $spectacle->horaire->format('Y-m-d'),
                    'horaire' => $spectacle->horaire->format('H:i'),
                    'images' => $spectacle->images,
                    'links' => [
                        'artistes' => [ 'href' => '/spectacles/' . $spectacle->ID . '/artistes']
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
            'spectacles' => $data,
            'links' => [
                'self' => [ 'href' => '/spectacles'],
            ]
        ];

        return JsonRenderer::render($rs, 200, $tabFinal);

    }
}
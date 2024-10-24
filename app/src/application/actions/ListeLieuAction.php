<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\user\ServiceUserInterface;
use nrv\core\services\user\ServiceUserNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListeLieuAction extends AbstractAction
{

    protected ServiceUserInterface $serviceUser;

    public function __construct(ServiceUserInterface $serviceUser)
    {
        $this->serviceUser = $serviceUser;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $lieux = $this->serviceUser->getLieux();
            $data = [];
            foreach ($lieux as $lieu) {
                $data[] = [
                    'lieu' => [
                        'ID' => $lieu->ID,
                        'nom' => $lieu->nom,
                        'adresse' => $lieu->adresse,
                        'ville' => $lieu->ville,
                        'nb_places_assises' => $lieu->nb_places_assises,
                        'nb_places_debout' => $lieu->nb_places_debout
                    ],
                    'links' => [
                        'spectacles' => ['href' => '/lieux/' . $lieu->ID . '/spectacles'],
                        'soirees' => ['href' => '/lieux/' . $lieu->ID . '/soirees']
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
        }

        $tabFinal = [
            'type' => 'collection',
            'count' => count($data),
            'lieux' => $data,
            'links' => [
                'self' => [
                    'href' => '/lieux'
                ]
            ]
        ];

        return JsonRenderer::render($rs, 200, $tabFinal);
    }
}
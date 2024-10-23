<?php

namespace nrv\application\actions;

use nrv\application\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use nrv\application\renderer\JsonRenderer;
use nrv\core\services\user\ServiceUserInterface;
use nrv\core\services\user\ServiceUserNotFoundException;


class ListeSpectacleByLieuAction extends AbstractAction
{

    protected ServiceUserInterface $serviceUser;

    public function __construct(ServiceUserInterface $serviceUser)
    {
        $this->serviceUser = $serviceUser;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $id = $args['ID_Lieu'];

        try {
            $spectacles = $this->serviceUser->getSpectaclesByLieu($id);
            $data = [];
            foreach ($spectacles as $spectacle) {
                $data[] = [
                    'spectacle' => [
                        'titre' => $spectacle->titre,
                        'description' => $spectacle->description,
                        'date' => $spectacle->horaire->format('Y-m-d'),
                        'horaire' => $spectacle->horaire->format('H:i'),
                        'images' => $spectacle->images,
                        'style' => $spectacle->style,
                    ],
                    'links' => [
                        'artistes' => ['href' => '/spectacles/' . $spectacle->ID . '/artistes'],
                        'soiree' => ['href' => '/spectacles/' . $spectacle->ID . '/soiree']
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

        $tabFinal = [
            'type' => 'collection',
            'count' => count($data),
            'spectacles' => $data,
            'links' => [
                'self' => ['href' => '/lieu/' . $id . '/spectacles'],
            ]
        ];
        return JsonRenderer::render($rs, 200, $tabFinal);
    }
}

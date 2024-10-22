<?php

namespace nrv\application\actions;

use nrv\application\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use nrv\application\renderer\JsonRenderer;
use nrv\core\services\user\ServiceUserInterface;
use nrv\core\services\user\ServiceUserNotFoundException;


class ListeSpectacleSoireeAction extends AbstractAction
{

    protected ServiceUserInterface $soireeRepository;

    public function __construct(ServiceUserInterface $soireeRepository)
    {
        $this->soireeRepository = $soireeRepository;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $id = $args['id'];

        try {
            $spectacles = $this->soireeRepository->getSpectaclesBySoireeId($id);
            $data = [];
            foreach ($spectacles as $spectacle) {
                $data[] = [
                    'titre' => $spectacle->titre,
                    'date' => $spectacle->horaire->format('Y-m-d'),
                    'horaire' => $spectacle->horaire->format('H:i'),
                    'images' => $spectacle->images,
                    'links' => [
                        'artistes' => ['href' => '/spectacles/' . $spectacle->ID . '/artistes']
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
            'type' => 'ressource',
            'locale' => 'fr_FR',
            'spectacles' => $data,
            'links' => [
                'self' => ['href' => '/soiree/' . $id . '/spectacles'],
            ]
        ];
        return JsonRenderer::render($rs, 200, $tabFinal);
    }
}

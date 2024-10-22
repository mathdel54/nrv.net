<?php

namespace nrv\application\actions;

use nrv\application\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use nrv\application\renderer\JsonRenderer;
use nrv\core\services\user\ServiceUserInterface;

class ListeSpectacleSoireeAction extends AbstractAction {

    protected ServiceUserInterface $soireeRepository;

    public function __construct(ServiceUserInterface $soireeRepository) {
        $this->soireeRepository = $soireeRepository;
    }
    
    public function __invoke(Request $rq, Response $rs, array $args): Response {
        $id = $args['id'];
        $spectacles = $this->soireeRepository->getSpectaclesBySoireeId($id);
        $data = [];
        foreach ($spectacles as $spectacle) {
            $data[] = $spectacle;
        }

        $tabFinal = [
            'type' => 'ressource',
            'spectacles' => $data,
            'links' => [
                'self' => [ 'href' => '/soiree/' . $id . '/spectacles'],
            ]
        ];
        return JsonRenderer::render($rs, 200, $data);
    }
}
<?php

namespace nrv\application\actions;

use nrv\core\services\user\ServiceUserInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\application\renderer\JsonRenderer;
use nrv\core\services\user\ServiceUserNotFoundException;

class DetailSoireeAction extends AbstractAction {

    protected ServiceUserInterface $soireeRepository;

    public function __construct(ServiceUserInterface $soireeRepository) {
        $this->soireeRepository = $soireeRepository;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface {
        $id = $args['id'];

        try {
        $soiree = $this->soireeRepository->getSoireeById($id);
        
        $data = [];
        $data[] = $soiree;
        
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
            'soiree' => $data,
            'links' => [
                'spectacles' => [ 'href' => '/soiree/' . $id . '/spectacles'],
                'self' => [ 'href' => '/spectacles/'],

            ]
        ];
        
        return JsonRenderer::render($rs, 200, $tabFinal);
    }
}
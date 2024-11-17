<?php

namespace nrv\application\actions;

use nrv\core\dto\billet\InputBilletDTO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\application\renderer\JsonRenderer;
use nrv\core\services\user\ServiceUserInterface;
use nrv\core\services\user\ServiceUserNotFoundException;

class UpdateBilletAction extends AbstractAction
{

    protected ServiceUserInterface $serviceUser;

    public function __construct(ServiceUserInterface $serviceUser)
    {
        $this->serviceUser = $serviceUser;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $id_billet = $args['id'] ?? null;

            $billet = $this->serviceUser->updateBillet($id_billet);

            $data = [
                'billet' => [
                    'user' => $billet->user,
                    'tarif' => $billet->tarif,
                    'date' => $billet->date,
                    'soiree' => [
                        'ID' => $billet->soiree->ID,
                        'nom' => $billet->soiree->nom,
                        'theme' => $billet->soiree->theme,
                        'date' => $billet->soiree->horaire->format('Y-m-d'),
                        'horaire' => $billet->soiree->horaire->format('H:i'),
                        'lieu' => $billet->soiree->lieu->ID,
                        'tarifNormal' => $billet->soiree->tarifNormal,
                        'tarifReduit' => $billet->soiree->tarifReduit,
                    ]
                ],
                'links' => [
                    'soiree' => ['href' => '/soirees/' . $billet->soiree->ID]
                ]
            ];
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
        return JsonRenderer::render($rs, 200, $data);
    }
}
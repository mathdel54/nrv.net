<?php

namespace nrv\application\actions;

use nrv\core\dto\billet\InputBilletDTO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\application\renderer\JsonRenderer;
use nrv\core\services\user\ServiceUserInterface;
use nrv\core\services\user\ServiceUserNotFoundException;

class UpdateBilletAction extends AbstractAction {

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
                    'soiree' => $billet->soiree,
                ],
                'links' => [
                    'soiree' => ['href' => '/soirees/' . $billet->soiree ]
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
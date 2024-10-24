<?php

namespace nrv\application\actions;

use nrv\core\dto\billet\InputBilletDTO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\application\renderer\JsonRenderer;
use nrv\core\services\user\ServiceUserInterface;
use nrv\core\services\user\ServiceUserNotFoundException;

class AchatBilletAction extends AbstractAction {

    protected ServiceUserInterface $serviceUser;

    public function __construct(ServiceUserInterface $serviceUser)
    {
        $this->serviceUser = $serviceUser;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $id_user = $rq->getParsedBody()['id_user'] ?? null;
            $id_soiree = $rq->getParsedBody()['id_soiree'] ?? null;
            $tarif = $rq->getParsedBody()['tarif'] ?? null;

            $dtoBillet = new InputBilletDTO($id_user, $tarif, $id_soiree);

            $billet = $this->serviceUser->acheterBillet($dtoBillet);

            $data = [
                'billet' => [
                    'user' => $billet->user,
                    'tarif' => $billet->tarif,
                    'date' => $billet->date,
                    'soiree' => $billet->soiree,
                ],
                'links' => [
                    'soiree' => ['href' => '/soiree/' . $billet->soiree ]
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
<?php 

namespace nrv\application\actions;

use nrv\core\services\user\ServiceUserInterface;
use nrv\core\services\user\ServiceUserNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\application\renderer\JsonRenderer;

class ListeBilletUser extends AbstractAction {

    protected ServiceUserInterface $serviceUser;

    public function __construct(ServiceUserInterface $serviceUser)
    {
        $this->serviceUser = $serviceUser;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['id_user'];

        try {
            $billets = $this->serviceUser->getBilletsByUser($id);

            $data = [];
            foreach ($billets as $billet) {
                $data[] = [
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
            'billets' => $data,
            'links' => [
                'self' => ['href' => '/users/' . $id . '/billets']
            ]
        ];
        return JsonRenderer::render($rs, 200, $tabFinal);
    }
}
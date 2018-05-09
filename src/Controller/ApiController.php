<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Http\Response;

/**
 * Api Controller
 *
 */
class ApiController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
    }

    public function beforeRender(Event $event)
    {
        $this->set('_serialize', true);
    }

    /**
     * @param array $data
     *
     * @return Response
     */
    public function respondBadRequest(Array $data)
    {
        return $this->respond($data, 400);
    }

    /**
     * @param array $data
     * @param int $code
     *
     * @return Response
     */
    public function respond(Array $data, int $code = 200)
    {
        return $this->getResponse()->withStatus($code)->withStringBody(json_encode($data));
    }

    /**
     * @param array $data
     *
     * @return Response
     */
    public function respondNotFound(Array $data)
    {
        return $this->respond($data, 404);
    }

    /**
     * @param array $data
     *
     * @return Response
     */
    public function respondSuccess(Array $data)
    {
        return $this->respond($data, 200);
    }
}

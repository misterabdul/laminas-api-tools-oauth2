<?php

namespace User\Service\Listener;

use Laminas\Http\Response;

class UnauthorizedUserListener
{
    /**
     * Check response with 401 status code
     *
     * @param  \Laminas\Mvc\MvcEvent  $ev
     */
    public function __invoke($ev)
    {
        $response = $ev->getResponse();
        if (
            $response instanceof Response
            && $response->getStatusCode() === Response::STATUS_CODE_401
        ) {
            $response->getHeaders()->addHeaderLine('Www-Authenticate', 'Bearer realm="Service"');
        }

        return;
    }
}

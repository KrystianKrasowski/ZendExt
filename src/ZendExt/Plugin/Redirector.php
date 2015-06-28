<?php

namespace ZendExt\Plugin;

use Zend\Http\Response;
use ZendExt\ServiceManager\Annotation\Inject;
use ZendExt\ServiceManager\Annotation\Service;

/**
 * @Service()
 */
class Redirector
{
    /**
     * @var Response
     * @Inject(name="Response")
     */
    private $response;

    public function toUrl($url = null)
    {
        if ($url === null) {
            $url = $this->getCurrentPath();
        }

        $response = $this->response;
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);
        return $response;
    }

    private function getCurrentPath()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
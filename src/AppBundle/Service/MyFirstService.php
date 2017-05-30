<?php

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\Session\Session;

class MyFirstService
{
    private $container;

    private $session;


    public function __construct(Container $container, Session $session)
    {
        $this->container = $container;
        $this->session = $session;
    }

    public function setFlash($message, $type = 'notice')
    {
        $this->session->getFlashBag()->add(
            $type,
            $message
        );
    }

}
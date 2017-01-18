<?php

namespace ChasseBundle\EventListener;

use ChasseBundle\Controller\OpeningController;
use DateTime;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Routing\Router;


class OpeningListener
{
    private $openDate;
    private $currentDate;
    private $closeDate;

    public function __construct(\Symfony\Component\HttpKernel\Controller\ControllerResolver $resolver, Router $router)
    {
        $this->openDate = new DateTime('2017-01-12 10:00:00');
        $this->closeDate = new DateTime('2017-01-17 00:01:00');
        $this->currentDate = new DateTime();
        $this->resolver = $resolver;
        $this->router = $router;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        $request = new Request();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof OpeningController) {
            if ($this->openDate > $this->currentDate)
            {
                $redirectUrl= $this->router->generate('countdown');
                $event->setController(function() use ($redirectUrl) {
                    return new RedirectResponse($redirectUrl);
                });
            }
            else if ($this->closeDate < $this->currentDate)
            {
                $redirectUrl= $this->router->generate('finished');
                $event->setController(function() use ($redirectUrl) {
                    return new RedirectResponse($redirectUrl);
                });
            }
            else
            {
                return;
            }
        }
    }
}
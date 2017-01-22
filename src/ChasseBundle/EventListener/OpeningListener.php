<?php

namespace ChasseBundle\EventListener;

use ChasseBundle\Controller\OpeningController;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class OpeningListener
{
    private $openDate;
    private $currentDate;
    private $closeDate;
    private $resolver;

    public function __construct(\Symfony\Component\HttpKernel\Controller\ControllerResolver $resolver)
    {
        $this->openDate = new DateTime('2017-01-19 09:30:45');
        $this->closeDate = new DateTime('2017-02-10 23:59:59');
        $this->resolver = $resolver;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $this->currentDate = new DateTime();
        $controller = $event->getController();
        $request = new Request();

        if (is_array($controller)) {
            if ($controller[0] instanceof OpeningController) {
                if ($this->openDate > $this->currentDate) {
                    $request->attributes->set('_controller', 'ChasseBundle:Front:countdown');
                    $event->setController($this->resolver->getController($request));
                } else if ($this->closeDate < $this->currentDate) {
                    $request->attributes->set('_controller', 'ChasseBundle:Front:finished');
                    $event->setController($this->resolver->getController($request));
                }
            }
        }
        return;
    }
}
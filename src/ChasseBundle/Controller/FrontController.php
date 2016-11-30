<?php

namespace ChasseBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class FrontController extends Controller
{
    private $openDate;
    private $currentDate;

    public function __construct()
    {
        $this->openDate = new DateTime('2016-12-30 18:00:00');
        $this->currentDate = new DateTime();
    }

    private function countDown()
    {
        if ($this->openDate > $this->currentDate) {
            $direct = $this->forward('ChasseBundle:Front:countdown');

            return $direct;
        } else {
            return;
        }
    }

    public function indexAction()
    {
        $this->countDown();
        return $this->render('Front/index.html.twig', array(// ...
        ));

    }

    public function howtoAction()
    {
        $this->countDown();
        return $this->render('Front/howto.html.twig', array(// ...
        ));
    }

    public function legalmentionAction()
    {
        $this->countDown();
        return $this->render('Front/legalmention.html.twig', array(// ...
        ));
    }

    public function inscriptAction()
    {
        $this->countDown();
        return $this->render('Front/inscript.html.twig', array(// ...
        ));
    }

    public function countdownAction()
    {
        if ($this->openDate < $this->currentDate) {
            $direct = $this->forward('ChasseBundle:Front:index');

            return $direct;
        }
        return $this->render('Front/countdown.html.twig', array(// ...
        ));
    }
}

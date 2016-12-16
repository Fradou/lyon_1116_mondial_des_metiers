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
        $this->openDate = new DateTime('2017-12-2 10:00:00');

        $this->currentDate = new DateTime();
    }

    private function countDown($render)
    {
        if ($this->openDate > $this->currentDate) {
            $direct = $this->render('Front/countdown.html.twig');

            return $direct;
        } else {
            return $render;
        }
    }

    public function indexAction()
    {
        $render = $this->render('Front/index.html.twig', array(// ...
        ));
        return $this->countDown($render);
    }

    public function howtoAction()
    {
        $render = $this->render('Front/howto.html.twig', array(// ...
        ));
        return $this->countDown($render);
    }

    public function legalmentionAction()
    {
        $render = $this->render('Front/legalmention.html.twig', array(// ...
        ));
        return $this->countDown($render);
    }

    public function inscriptAction()
    {
        $render = $this->render('Front/inscript.html.twig', array(// ...
        ));
        return $this->countDown($render);
    }

    public function countdownAction()
    {
        if ($this->openDate < $this->currentDate) {
            $direct = $this->render('Front/index.html.twig');

            return $direct;
        }
        return $this->render('Front/countdown.html.twig', array(// ...
        ));
    }
}

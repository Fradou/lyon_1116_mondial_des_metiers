<?php

namespace ChasseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{
    public function indexAction()
    {
        return $this->render('Front/index.html.twig', array(
            // ...
        ));
    }

    public function howtoAction()
    {
        return $this->render('Front/howto.html.twig', array(
            // ...
        ));
    }

    public function legalmentionAction()
    {
        return $this->render('Front/legalmention.html.twig', array(
            // ...
        ));
    }

    public function inscriptAction()
    {
        return $this->render('Front/inscript.html.twig', array(
            // ...
        ));
    }

    public function countdownAction()
    {
        return $this->render('Front/countdown.html.twig', array(
            // ...
        ));
    }

}

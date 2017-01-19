<?php

namespace ChasseBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class FrontController extends Controller
{
    public function indexAction()
    {
        return $this->render('Front/index.html.twig');
    }

    public function howtoAction()
    {
        return $this->render('Front/howto.html.twig');
    }

    public function legalmentionAction()
    {
        return $this->render('Front/legalmention.html.twig', array(// ...
        ));
    }

    public function learnmoreAction()
    {
        return $this->render('Front/learnmore.html.twig');
    }

    public function countdownAction()
    {
        return $this->render('Front/countdown.html.twig', array(// ...
        ));
    }

    public function finishedAction(){
        return $this->render('Front/end.html.twig', array(// ...
        ));
    }

    public function voteValidAction()
    {
        $user = $this->getUser()->getId();

        $repository = $this->getDoctrine()->getRepository('ChasseBundle:User');
        $satisf = $repository->checkSatisf($user);

        if ($satisf != 0){

            $repository = $this->getDoctrine()->getRepository('ChasseBundle:Interview');
            $vote = $repository->checkVote($user);

            return $this->render('Front/votevalid.html.twig', array(
                'vote' => $vote));
        }
        else {
            return $this->redirectToRoute('user_edit', array(
                'id' => $user));
        }
    }
}

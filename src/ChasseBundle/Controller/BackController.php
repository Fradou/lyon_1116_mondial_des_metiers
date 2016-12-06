<?php

namespace ChasseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackController extends Controller
{
    public function statsAction()
    {
        //nb de user enregistrés
        $userManager = $this->container->get('fos_user.user_manager');
        $users = count($userManager->findUsers());

        //nb de user ayant au moins répondu à un métier
        $activeUsers = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->getCountUsers();

        //nombre de métiers répondus
        $nbjobs = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->getCountJobs();

        $mostAnsweredJobs = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->get20jobs();

        $mostAnsweredDomains = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->get20domains();


        return $this->render('Back/stats.html.twig', array(
            "totalusers" => $users,
            "activeusers" => $activeUsers,
            "nbjobs"    => $nbjobs,
            "mostAnsweredJobs" => $mostAnsweredJobs,
            "mostAnsweredDomains" => $mostAnsweredDomains,

        ));
    }

}

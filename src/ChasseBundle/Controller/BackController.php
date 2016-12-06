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

        //nombre de domaines répondus
        $nbDomains = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->getCountDomains();

        // les 20 métiers les plus répondus
        $mostAnsweredJobs = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->get20jobs();

        //les 20 domaines les plus répondus
        $mostAnsweredDomains = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->get20domains();


        return $this->render('Back/stats.html.twig', array(
            "totalusers" => $users,
            "activeusers" => $activeUsers,
            "nbjobs"    => $nbjobs,
            "nbdomains" => $nbDomains,
            "mostAnsweredJobs" => $mostAnsweredJobs,
            "mostAnsweredDomains" => $mostAnsweredDomains,

        ));
    }

}

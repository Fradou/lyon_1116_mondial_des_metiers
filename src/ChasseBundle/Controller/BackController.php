<?php

namespace ChasseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BackController extends Controller
{
    public function statsAction()
    {
        //nb of registered users
        $userManager = $this->container->get('fos_user.user_manager');
        $users = count($userManager->findUsers());

        //nb of user who answered at least one job
        $activeUsers = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->getCountUsers();

        //nb of aswered jobs
        $nbjobs = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->getCountJobs();

        //nb of answered domains
        $nbDomains = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->getCountDomains();

        //  20 most answered jobs
        $mostAnsweredJobs = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->get20jobs();

        // 20 most answered domains
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

    public function userStatsAction () {
        //list of email who subscribed newsletter
        $subscribers = $this->getDoctrine()->getRepository('ChasseBundle:User')->getSubscribers();
        //nb of male/female users
        $genders = $this->getDoctrine()->getRepository('ChasseBundle:User')->countGender();

        //classment of the most registered status among users (student, employee, etc.)

        //classment by age category

        return $this->render('Back/userstats.html.twig', array(
            "subscribers" => $subscribers,
            "genders" => $genders,


        ));
    }
}

<?php

namespace ChasseBundle\Controller;

use ChasseBundle\ChasseBundle;
use ChasseBundle\Entity\User;
use ChasseBundle\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;


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

        // selected persons
        $selectedPersons = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->getSelectedUsers();
        $eligibleuser = count($selectedPersons);


        // 20 most answered words
        $words = $this->getDoctrine()->getRepository('ChasseBundle:Answer')->mostUsed();


        return $this->render('Back/stats.html.twig', array(
            "totalusers"    =>      $users,
            "activeusers"   =>      $activeUsers,
            "nbjobs"        =>      $nbjobs,
            "nbdomains"     =>      $nbDomains,
            "mostAnsweredJobs" =>   $mostAnsweredJobs,
            "mostAnsweredDomains" => $mostAnsweredDomains,
            "words" => $words,
            "eligibleuser" => $eligibleuser,
        ));
    }

    public function userStatsAction ($page = 1) {
        //paginator
        $start = ($page-1) * UserRepository::MAX_RESULT;
        $nbresults = UserRepository::MAX_RESULT;
        $subscribers = $this->getDoctrine()->getRepository('ChasseBundle:User')->getSubscribers($start, $nbresults);
        $total = count($subscribers);
        $maxPage = intval($total/UserRepository::MAX_RESULT);

        //nb of registered users
        $userManager = $this->container->get('fos_user.user_manager');
        $users = count($userManager->findUsers());

        //list of email who subscribed newsletter
        //$subscribers = $this->getDoctrine()->getRepository('ChasseBundle:User')->getSubscribers();

        //nb of male/female users
        $genders = $this->getDoctrine()->getRepository('ChasseBundle:User')->countGender();

        //classment of the most registered status among users (student, employee, etc.)
        $statuses = $this->getDoctrine()->getRepository('ChasseBundle:User')->getMostRegStatus();

        //classment by age category
        $agecategory = [];
        $agecategory[] = ["-16 ans", $this->getDoctrine()->getRepository('ChasseBundle:User')->getAgeCategories(0,16)];
        $agecategory[] = ["17-20 ans", $this->getDoctrine()->getRepository('ChasseBundle:User')->getAgeCategories(17,20)];
        $agecategory[] = ["21-25 ans", $this->getDoctrine()->getRepository('ChasseBundle:User')->getAgeCategories(21,25)];
        $agecategory[] = ["26-35 ans", $this->getDoctrine()->getRepository('ChasseBundle:User')->getAgeCategories(26,35)];
        $agecategory[] = ["36-45 ans", $this->getDoctrine()->getRepository('ChasseBundle:User')->getAgeCategories(36,45)];
        $agecategory[] = ["46+ ans", $this->getDoctrine()->getRepository('ChasseBundle:User')->getAgeCategories(46, 100)];

        //classment of most registered departments
        $departments = $this->getDoctrine()->getRepository('ChasseBundle:User')->getMostRegDepartment();

        return $this->render('Back/userstats.html.twig', array(
            "genders" => $genders,
            "statuses" => $statuses,
            "agecategory" => $agecategory,
            "departments" => $departments,
            "subscribers" => $subscribers,
            'page'        => $page,
            'maxPage'     => $maxPage,
            'total'       => $total,
            "totalusers"  => $users,
        ));
    }

    //ACTION TO GENERATE A CSV FILE FROM USERS
    public function generateCsvAction() {
        $repository = $this->getDoctrine()->getRepository('ChasseBundle:User');

        $response = new StreamedResponse();

        $response->setCallback(function() use ($repository) {
            $date = new DateTime();
            $strdate = $date->format('d-m-Y\H:i:s');
            $filename = 'csv/inscrits-newsletter-'.$strdate.'.csv';

            $handle = fopen($filename, 'w+');

            fputcsv($handle, ['username', 'email', 'newsletter'], ';');

            $results = $repository->getSubscribers(0);
            //var_dump($results);
            foreach ($results as $user) {
                fputcsv(
                    $handle,
                    [$user->getUsername(), $user->getEmail(), $user->getNewsletter()],
                    ';'
                );
            }

            fclose($handle);
        });
        /*
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition','attachment; filename="export-users.csv"');
        */

        return $response;
    }

    public function winnerAction() {

        // selected persons
        $selectedPersons = $this->getDoctrine()->getRepository('ChasseBundle:Interview')->getSelectedUsers();

        //get the winner
        $randArrayInt = random_int(0, count($selectedPersons)-1);
        $winner = $selectedPersons[$randArrayInt];


        return $this->render('Back/winner.html.twig', array(
            "winner"          =>    $winner,
        ));
    }

    function __toString()
    {
        return strval($this->id);
    }
}

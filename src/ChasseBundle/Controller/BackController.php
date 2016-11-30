<?php

namespace ChasseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackController extends Controller
{
    public function statsAction()
    {
        $userManager = $container->get('fos_user.user_manager');
        $users = count($userManager->findUsers());



        return $this->render('Back/stats.html.twig', array(
            "totalusers" => $users

        ));
    }

}

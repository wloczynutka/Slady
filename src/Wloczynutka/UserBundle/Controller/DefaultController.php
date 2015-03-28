<?php

namespace Wloczynutka\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $templateVars = array(
            'loginUrl' => 'login',
            'registerUrl' => 'register',
        );
        return $this->render('UserBundle:Default:index.html.twig', $templateVars);
    }
}

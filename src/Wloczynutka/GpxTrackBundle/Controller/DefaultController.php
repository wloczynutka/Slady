<?php

namespace Wloczynutka\GpxTrackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GpxTrackBundle:Default:index.html.twig', array('name' => $name));
    }
}

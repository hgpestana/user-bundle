<?php

namespace HGPestana\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HGPestanaUserBundle:Default:index.html.twig');
    }
}

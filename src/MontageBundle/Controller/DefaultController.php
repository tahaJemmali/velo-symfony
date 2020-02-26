<?php

namespace MontageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MontageBundle:Default:index.html.twig');
    }
}

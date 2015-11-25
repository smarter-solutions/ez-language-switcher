<?php

namespace SmarterSolutions\EzComponents\EzLanguageSwitcherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EzLanguageSwitcherBundle:Default:index.html.twig', array('name' => $name));
    }
}

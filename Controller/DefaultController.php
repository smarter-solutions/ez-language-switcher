<?php

namespace SmarterSolutions\EzComponents\EzLanguageSwitcherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $service = $this->get('smarter.ezcomponents.language_switcher');

        var_dump($service->getCurrentEzLocale());
        exit;
        return $this->render('EzLanguageSwitcherBundle:Default:index.html.twig', array('name' => $name));
    }
}

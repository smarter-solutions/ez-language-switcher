<?php

namespace SmarterSolutions\EzComponents\EzLanguageSwitcherBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $service = $this->get('smarter.ezcomponents.language_switcher');

        // var_dump($this->getRequest()->attributes->all());
        var_dump($this->getRootLocation());
        var_dump($service->getLanguagesData($this->getRootLocation()));
        exit;
        return $this->render('EzLanguageSwitcherBundle:Default:index.html.twig', array('name' => $name));
    }
}

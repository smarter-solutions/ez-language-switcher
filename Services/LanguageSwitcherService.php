<?php

/**
 * Este archivo es un servicio que permite obtener los diferentes lenguages
 * que se encuentran disponibles en la instalación de eZ Publish
 *
 */
namespace SmarterSolutions\EzComponents\EzLanguageSwitcherBundle\Services;


class LanguageSwitcherService
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var \eZ\Publish\Core\MVC\Symfony\Routing\ChainRouter
     */
    private $router;

    /**
     * @var \eZ\Publish\Core\Helper\TranslationHelper
     */
    private $translation_helper;

    /**
     * @var \eZ\Publish\Core\MVC\Symfony\Routing\Generator\RouteReferenceGenerator
     */
    private $route_reference_generator;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * Arreglo que contiene la conversión de lenguages estandar con los de eZ Publish
     * @var array
     */
    private $conversion_map;

    function __construct($container)
    {
        $this->container = $container;
        $this->router = $container->get('router');
        $this->translation_helper = $container->get('ezpublish.translation_helper');
        $this->route_reference_generator = $container->get('ezpublish.route_reference.generator');
        $this->request = $container->get('request');
        $this->conversion_map = $container->getParameter('ezpublish.locale.conversion_map');

        // var_dump($container->getParameter( 'ezpublish.locale.conversion_map' ));
    }

    /**
     * Permite obtener el lenguage actual con la codificación de eZ Publish
     * @return [type] [description]
     */
    public function getCurrentEzLocale()
    {
        return array_search($this->request->get( '_locale'),$this->conversion_map);
    }
}
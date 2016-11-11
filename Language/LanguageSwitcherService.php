<?php
/**
 * Este archivo es un servicio que permite obtener los diferentes lenguages
 * que se encuentran disponibles en la instalación de eZ Publish
 *
 */
namespace SmarterSolutions\EzComponents\EzLanguageSwitcherBundle\Language;

use Symfony\Component\DependencyInjection\ContainerInterface;
use eZ\Publish\Core\Repository\Values\Content\Location;
use SmarterSolutions\EzComponents\EzLanguageSwitcherBundle\Language\LanguageSwitcherContent;

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
    private $translationHelper;

    /**
     * @var \eZ\Publish\Core\MVC\Symfony\Routing\Generator\RouteReferenceGenerator
     */
    private $routeReferenceGenerator;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var \eZ\Publish\Core\Persistence\Cache\ContentLanguageHandler
     */
    private $languageHandler;

    /**
     * Arreglo que contiene la conversión de lenguages estandar con los de eZ Publish
     * @var array
     */
    private $conversionMap;

    /**
     * @var array
     */
    private $customNames;

    /**
     * Constructor
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->router = $container->get('router');
        $this->customNames = $container->getParameter('ezlanguageswitcher.names');
        $this->translationHelper = $container->get('ezpublish.translation_helper');
        $this->routeReferenceGenerator = $container->get('ezpublish.route_reference.generator');
        $this->request = $container->get('request_stack')->getMasterRequest();
        $this->languageHandler = $container->get('ezpublish.spi.persistence.cache.contentlanguagehandler');
        $this->conversionMap = $container->getParameter('ezpublish.locale.conversion_map');
    }

    /**
     * Permite obtener una lista de LanguageSwitcherContent
     * @param  \eZ\Publish\Core\Repository\Values\Content\Location $location
     * @return \SmarterSolutions\EzComponents\EzLanguageSwitcherBundle\Language\LanguageSwitcherContent[]
     */
    public function getLanguages($location)
    {
        $languageList = array();
        $routeRef = $this->getRefRouter($location);

        foreach ($this->languageHandler->loadAll() as $language) {
            $siteAccess = $this->getSiteAccess($language->languageCode);

            if (is_null($siteAccess)) {
                continue;
            }

            $routeRef->set('siteaccess', $siteAccess);

            $languageList[] = new LanguageSwitcherContent(
                $language,
                $this->getLanguageName($language),
                $siteAccess,
                $this->router->generate(
                    $routeRef,
                    $this->request->query->all(),
                    true
                ),
                $this->isCurrentLocale($language->languageCode)
            );
        }
        return $languageList;
    }
    /**
     * Permite obtener el nombre que se configuro por cada lenguaje.
     * @param  \eZ\Publish\SPI\Persistence\Content\Language $language
     * @return string
     */
    private function getLanguageName($language)
    {
        $languageName = $language->name;
        $languageCode = str_replace('-', '_', $language->languageCode);
        try {
            $languageName = $this->customNames[$languageCode];
        } catch (\Exception $e) {

        }
        return $languageName;
    }

    /**
     * Permite obtener el siteacces segun el codigo del lenguaje eZ.
     * @param  string $languageCode Codigodel lenguaje segun eZ
     * @return string
     */
    private function getSiteAccess($languageCode)
    {
        return $this->translationHelper
                            ->getTranslationSiteAccess(
                                $languageCode
                            )
        ;
    }

    /**
     * Permite obtener el lenguage actual con la codificación de eZ Publish
     * @return string
     */
    private function getCurrentEzLocale()
    {
        return array_search(
            $this->request->get('_locale'),
            $this->conversionMap
        );
    }

    /**
     * Valida si el locale que se le pasa es el locale actual del usuario
     * @param  string  $locale
     * @return boolean
     */
    private function isCurrentLocale($locale)
    {
        return $locale == $this->getCurrentEzLocale();
    }

    /**
     * Permite obtener el objeto que peritira generar la url con los routers de eZ Publish
     * @param  \eZ\Publish\Core\Repository\Values\Content\Location $location
     * @return \eZ\Publish\Core\MVC\Symfony\Routing\RouteReference
     */
    private function getRefRouter($location)
    {
        $isValidRouter = $this->isValidRouter();

        return $this->routeReferenceGenerator->generate(
            $isValidRouter ? $this->request->attributes->get('_route') : $location,
            $isValidRouter ? $this->request->attributes->get('_route_params') : array()
        );
    }

    /**
     * Permite validar si el router es valido
     * @return boolean
     */
    private function isValidRouter()
    {
        $isValid = false;
        if ($this->request->attributes->has('_route')) {
            $router = $this->request->attributes->get('_route');
            $semanticPathinfo = $this->request->attributes->get('semanticPathinfo');

            $isValid = $router != 'ez_legacy' || $router == 'ez_legacy' && in_array($semanticPathinfo, $this->getValidEzLegacyPath());
        }
        return $isValid;
    }

    /**
     * Permite obtener los routers de ez_legacy que son traducibles.
     * @return array
     */
    private function getValidEzLegacyPath()
    {
        return array(
            '/user/register',
            '/user/forgotpassword'
        );
    }
}

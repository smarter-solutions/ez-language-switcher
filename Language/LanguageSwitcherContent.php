<?php
namespace SmarterSolutions\EzComponents\EzLanguageSwitcherBundle\Language;

use eZ\Publish\SPI\Persistence\Content\Language;

/**
 * Objeto de contenidos del LanguageSwitcher
 */
class LanguageSwitcherContent
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $uri;
    /**
     * @var string
     */
    public $languageCode;
    /**
     * @var string
     */
    public $siteAccess;
    /**
     * @var boolean
     */
    public $isCurrent;
    /**
     * @var boolean
     */
    public $isEnabled;

    public function __construct(Language $language, $name, $siteAccess, $uri, $isCurrent)
    {
        $this->id = $language->id;
        $this->name = $name;
        $this->uri = $uri;
        $this->languageCode = $language->languageCode;
        $this->siteAccess = $siteAccess;
        $this->isCurrent = $isCurrent;
        $this->isEnabled = $language->isEnabled;
    }
}

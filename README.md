# eZ Language Switcher

This is a simple language selector easy to implement in any eZ Publish project

## Install Package

```shell
composer require smarter-solutions/ez-language-switcher "~2.0"
```

## Register Bundle

```php
// ezpublish/EzPublishKernel.php

class EzPublishKernel extends Kernel
{
    ...
    public function registerBundles()
    {
        ...
        $bundles = array(
            ...
            new SmarterSolutions\EzComponents\EzLanguageSwitcherBundle\EzLanguageSwitcherBundle()
            ...
        );
        ...
    }
}
```

## Configuration

```yml
# ezpublish/config/config.yml

ez_language_switcher:
    names:
        esl-ES: Castellano
        cat-ES: Català'
        eng-GB: English
```

## How do you use it?

Using the benefits of this component is very simple

### 1. Call service from a controller

```twig
{{render(controller(
    "MyBundle:MyController:myMethod",
    {
        'location': currentLocation
    }
))}}
```

### 2. Get available languages

```php

class MyController {
    /**
     * @param  \eZ\Publish\Core\Repository\Values\Content\Location $location
     */
    public function myMethod($location)
    {
        $service = $this->get('smarter.ezcomponents.language_switcher');
        
        return $this->render(
            'MyBundle:MyController:myMethod.html.twig',
            array('language_list' => $service->getLanguages($location))
        );
    }
}

// 
```
### 3. Use in template

```twig
{# MyBundle:MyController:myMethod.html.twig #}

{% if language_list is not empty%}
    <ul class="list-unstyled">
    {% for item in language_list %}
        <li class="{{item.isCurrent?'active':''}}">
            <a href="{{item.uri}}">{{item.name}}</a>
        </li>
    {% endfor %}
    </ul>
{% endif %}

```

## Resulting object


### Type

***SmarterSolutions\EzComponents\EzLanguageSwitcherBundle\Language\LanguageSwitcherContent***

### Public Properties

* id *integer*
* name' *string*
* uri *string*
* languageCode *string*
* siteAccess *string*
* isCurrent *boolean*
* isEnabled  *boolean*

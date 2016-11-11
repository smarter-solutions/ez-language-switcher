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
            new SmarterSolutions\EzComponents\EzImageCropBundle\EzImageCropBundle()
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

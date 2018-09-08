
Sitemap generator bundle for Symfony
============

[![Build Status](https://travis-ci.org/mkebza/SitemapBundle.svg?branch=master)](https://travis-ci.org/mkebza/SitemapBundle)

# Instalation

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require mkebza/sitemap-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require mkebza/sitemap-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new MKebza\Sitemap\MKebzaSitemapBundle(),
        );

        // ...
    }

    // ...
}
```

# Configuration
there is only one available configuration and that is `base_url`, its automatically prepended
to all url if they aren't fully quilified.

```yaml
m_kebza_sitemap:
    base_url: http://www.example.com

```
# Usage

Collecting routes works by implementing `MKebza\Sitemap\Service\SitemapLocationGeneratorInterface` 
which is then autoconfigured via symfony container. If you don't use autoconfiguration, you 
need to tag your service with `mkebza_sitemap.generator` tag to be used. 

## `SitemapLocationGeneratorInterface`

Has one method `generate()` which is generator and needs to yield object of
`MKebza\Sitemap\Service\Location`. 

## `Location`

You can either use absolute url or relative URL, which will be prepended by url set in your configuration.

## Generating sitemap

From your terminal run `bin/console sitemap:generate`, default path is `public/sitemap.xml`, 
but you can change it by passig path as first argument to the command.

You need to put this command to you cron / scheduler to generate sitemap on regular basis. 

cms-project
===

# pre-requisite

Follow User-Project instructions

# Installation

Require the bundle in your composer.json file:

```
// composer.json
{
    // ...
    require:{
        // ...
        "ardteam/cms-project" : "1.0.x@dev"
    }
}
```

Register the bundle:

``` php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new AT\Cms\ATCmsBundle(),
        // ...
    );
}
```

Install the bundle:

```
$ composer update
```

# Configuration

``` yaml
# Add to app/config/config.yml

# Twig Configuration
twig:
    # ...
    globals:
        google_analytics_ua: "%universal_analytics%"
        base_template: "ATCmsBundle:Core:base.html.twig"
```
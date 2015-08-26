# CMS-project

## Installation

Require the bundle in your composer.json file:

```
# composer.json
{
    // ...
    require:{
        // ...
        "ardteam/cms-project" : "1.0.x@dev",
        "friendsofsymfony/user-bundle": "@dev",
        "ardteam/user-project" : "@dev"
    }
}
```

Register the bundle in your application kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new AT\CmsBundle\ATCmsBundle(),
        new FOS\UserBundle\FOSUserBundle(),
        new AT\UserBundle\ATUserBundle(),
        // ...
    );
}
```

Add default parameters to "parameters.yml.dist"
```yaml
    # ...
    universal_analytics: ~
```

Install the bundle:

```
$ composer update
```

## Configuration

Edit your application config.yml, security.yml and routing.yml files adding following configuration:

``` yaml
# Add to app/config/config.yml

# Twig Configuration
twig:
    # ...
    globals:
        google_analytics_ua: "%universal_analytics%"
        base_template: "ATCmsBundle:Core:base.html.twig"

doctrine:
    dbal:
        # ...
        types:
            json: Sonata\Doctrine\Types\JsonType

fos_user:
    db_driver: orm
    firewall_name: main
    user_class: AT\UserBundle\Entity\User
```

``` yaml
# Add to app/config/security.yml

security
    encoders:
        AT\UserBundle\Entity\User: sha512

    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: [ROLE_USER, ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]

    providers:
        fos_userbundle:
            id: fos_user.user_provider.username

    firewalls:
        # ...

        main:
           pattern: ^/
           anonymous:    true
           form_login:
               provider: fos_userbundle
               login_path: fos_user_security_login
               check_path: fos_user_security_check
           logout:
                path: fos_user_security_logout
                target: / # route après logout
            remember_me:
                key: %secret% # %secret% est un paramètre de parameters.yml

    access_control:
        # ...
        - { path: ^/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/register, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/resetting, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/admin/, role: ROLE_ADMIN } # exemple de route à sécuriser
        # ...

```

Import FOSUser routes

``` yaml
# Add to app/config/routing.yml

# Sécurité & Connexion
fos_user:
    resource: "@FOSUserBundle/Resources/config/routing/all.xml"

```

Declare your main Bundle extending the ATCmsBundle

``` php
    # xxxBundle.php
    public function getParent()
    {
        return 'ATCmsBundle';
    }
```

and create a DefaultController extending "AT\CmsBundle\Controller\CoreController"

``` php
    <?php

    namespace AppBundle\Controller;

    use AT\CmsBundle\Controller\CoreController;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;

    class DefaultController extends CoreController
    {
    }

```

Generate the database schema.
> Don't forget to setup database parameters in "parameters.yml" file

```
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:update --force
```

## Usage

Create a user. For example :

```
$ php app/console fos:user:create <user_name> <user_email> <user_password> --super-admin
```
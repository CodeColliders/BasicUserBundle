Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require code-colliders/basic-user-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require code-colliders/basic-user-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    CodeColliders\BasicUserBundle\CodeCollidersBasicUserBundle::class => ['all' => true],
];
```

Configure the bundle (using command line tool)
----------------------------------------

Use `php bin/console basic-user:init` to create bundle configurations

Use `php bin/console basic-user:init -c User` to create bundle configurations and the User entity


Configure the bundle (manually)
----------------------------------------

### Step 1: Create a User class
```console
$ php bin/console make:entity User
```
the class must implement the `\Symfony\Component\Security\Core\User\UserInterface`
 
 or extends the `\CodeColliders\BasicUserBundle\Entity\UserBase`

### Step 2: create configurations

package config:
```yaml
# config/packages/code_colliders_basic_user.yaml

code_colliders_basic_user:
  user_class: App\Entity\User # The fully qualified class for your user
  redirect_route: home # Default redirection after login (default: login page)
  user_identifier: email # Unique field used in your user entity to login 
  branding: # Optional part
    logo_url: null # Picture url to add a logo in login form  
    background_url: null # Picture url to add a background image in login form page
    form_title: "Log in" # The title of the form (default: Log in)
    catchphrase: "Using basic user bundle" # A catchphrase at the bottom of the form
    form_identifier_type: email # Type of field for user identifier 
```
> you can use `php bin/console config:dump-reference code_colliders_basic_user` to get the configuration file reference.

routing:
```yaml
# config/routes/code_colliders_basic_user.yaml

basic_user_login:
  resource: '@CodeCollidersBasicUserBundle/Resources/config/routes.xml'
  prefix: /user # The prefix for routes '/login' and '/logout'
```

Configure the security bundle
----------------------------------------

```yaml
# config/packages/security.yaml

security:
    # Roles configurations
    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
    # https://symfony.com/doc/current/security.html#where-do-users-come-from-user-providers
    encoders:
        App\Entity\User:  # Your user class
            algorithm: auto

        # https://symfony.com/doc/current/security.html#where-do-users-come-from-user-providers
    providers:
        # used to reload user from session & other features (e.g. switch_user)
        app_user_provider:
            entity:
                class: App\Entity\User
                property: username

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            anonymous: true
            logout:
                path: code_colliders_basic_user_logout
            guard:
                authenticators:
                    - code_colliders_basic_user.authenticator



            # activate different ways to authenticate
            # https://symfony.com/doc/current/security.html#firewalls-authentication

            # https://symfony.com/doc/current/security/impersonating_user.html
            # switch_user: true

    # Easy way to control access for large sections of your site
    # Note: Only the *first* access control that matches will be used
    access_control:
        # - { path: ^/admin, roles: ROLE_ADMIN }
        # - { path: ^/profile, roles: ROLE_USER }

 
```
> you can use `php bin/console config:dump-reference security` to get the security configuration file reference.


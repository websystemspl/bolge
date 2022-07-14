# Bolge
Is a boilerplate code based on symfony components to create OOP way plugins for Wordpress

## Features
- Symfony routing
- MVC structure
- Symfony Dependency injection
- Twig
- Symfony Event Dispatcher
- Doctrine ORM to use database

## Installation

1. Clone Gitub repository to plugins directory in wordpress
```bash
git clone git@github.com:websystemspl/bolge.git
```
2. If pugin is used more than one time in one wordpress then change namespaces
3. Use composer to install dependencies
```
composer install
```
4. Activate plugin in wordpress

## Usage

### Config / Routes

When your application receives a request, it calls a controller action to generate the response. The routing configuration defines which action to run for each incoming URL.

Routes must be defined in /config/routes.yaml
First route is a fix to avoid symfony no index route error

```yaml
# Don't change it avoid index path symfony notification
index:
    path: /
    controller: Bolge\App\Core\DefaultController::defaultAction
    methods: [GET, POST]
```

For Wordpress wp-admin route path must starts from /wp-admin.

On Wordpress public side it overrides actual template using "template_include" Wordpress hook in WordpressFrontSubscriber.php

```php
add_filter('template_include')
```

so for example if you already have page /test created in admin panel and you will create route /test then whole content if this page will be overrided by Response from controller action set in this route.

For more see https://symfony.com/doc/current/routing.html

### Controllers

Controller is similar to symfony controller, it can directly receive Request in argument, do something and return Response using Twig templates or just JSON.

Controller can also use Services injected to his constructor:

```php
public function __construct(ViewInterface $view, EntityManagerInterface $em)
{
	$this->view = $view;
	$this->em = $em;
}
```

### Templating - Twig

Twig templates are implemented as Service and it is used to create modern html pages.

Templates should be created in /views directory and can be used by controller like this

```php
return $this->view->render('test.html.twig');
```

you can also pass parameters to twig template

```php
$customers = [
	'customer1',
	'customer2',
];

return $this->view->render('test.html.twig', [
	'customers' => $customers,
]);
```

For more information check https://twig.symfony.com/

### Entities / Entity Repositories

Doctrine is implemented to core of Bolge.
[under construction]

### Services

[under construction]

### Events / Event subscribers

[under construction]

### Assets

[under construction]

### Wordpress

[under construction]


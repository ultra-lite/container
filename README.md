[![Build Status](https://travis-ci.org/ultra-lite/container.svg?branch=master)](https://travis-ci.org/ultra-lite/container)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ultra-lite/container/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ultra-lite/container/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/ultra-lite/container/v/stable)](https://packagist.org/packages/ultra-lite/container)
[![MIT Licence](https://badges.frapsoft.com/os/mit/mit.svg?v=103)](https://opensource.org/licenses/mit-license.php)

# ![logo](https://avatars1.githubusercontent.com/u/16309098?v=3&s=100) Ultra-Lite Container

An ultra-lightweight DI container.  The Ultra-Lite container is PSR-11 compliant.  (Previous versions supported
container-interop instead.)

Use anonymous functions as factories to specify your services.

This container also supports the Delegate Lookup pattern, and comes with a basic composite container.

## Usage

### Setting services individually

```php
$container->set(
    'service-id',
    function (\Psr\Container\ContainerInterface $container) {
        return new \stdClass();
    }
);
```

### Setting services from a config file

Add factory closures to the container inline, or using a config file as below.

Example config file:

```php
return [
    'service-id' =>
        function (\Psr\Container\ContainerInterface $container) {
            return new \stdClass();
        },
];
```

Using config file:

```php
$container->configureFromFile('/wherever/config/di.php');
```


### Service retrieval

Get services out of the container like this:

```php
$object = $container->get('service-id');
```

### See if a service exists

Check if something is in the container like this:

```php
$thingExists = $container->has('service-id');
```

### Use with the Delegate Lookup pattern

If you're not using the Delegate Lookup concept from the Container-Interop standard, ignore this bit.  If you are,
you can do this:

```php
$container = new \UltraLite\Container\Container();
$delegateContainer = new \UltraLite\CompositeContainer\CompositeContainer(); // or any delegate container
$compositeContainer->addContainer($container); // will vary for other composite containers
$container->setDelegateContainer($myCompositeContainer);
```

The [Ultra-Lite Composite Container](https://github.com/ultra-lite/composite-container) is an extremely lightweight
delegate container you may wish to use.

When the container is asked for a service using ```get()```, it will return it.  It will pass the Composite Container
into the factory closure, so it is from here that any dependencies of your service will be retrieved.

## Alternatives

Ultra-Lite Container was originally inspired by [Pimple](https://github.com/silexphp/Pimple), which still makes an
excellent DI container in PHP.  Container-Interop compliant wrappers are available.  Another excellent project,
[Picotainer](https://github.com/thecodingmachine/picotainer), is along similar lines, with the principle difference
being that the dependencies are defined at the time of instantiation of the container.

## Installation

```bash
composer require ultra-lite/container
```

## Contributions

Contributions welcome.

You can run the tests with ```./vendor/bin/behat -c tests/behat/behat.yml``` and ```./vendor/bin/phpspec r -c tests/phpspec/phpspec.yml```.

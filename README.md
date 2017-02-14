[![Build Status](https://travis-ci.org/ultra-lite/container.svg?branch=master)](https://travis-ci.org/ultra-lite/container)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ultra-lite/container/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ultra-lite/container/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/ultra-lite/container/v/stable)](https://packagist.org/packages/ultra-lite/container)

# ![logo](https://avatars1.githubusercontent.com/u/16309098?v=3&s=100) Ultra-Lite Container

An ultra-lightweight DI container, filling a Pimple-shaped gap in a Container-Interop world.

Using anonymous functions as factories for creating dependencies.  Inspired by Pimple DI.

Aims for full compliance with the Container-Interop standard, including the optional Delegate Lookup feature.

As of version `4.0`, PHP 7.0+ is required.

## Usage

### Setting services individually

```php
$container->set(
    'service-id',
    function (\Interop\Container\ContainerInterface $container) {
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
        function (\Interop\Container\ContainerInterface $container) {
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

### Use with a delegate container

If you're not using the Delegate Container concept from the Container-Interop standard, ignore this bit.  If you are,
do this:

```php
$container = new \UltraLite\Container\Container();
// ... (configure container)
$myCompositeContainer->addContainer($container); // or whatever
$container->setDelegateContainer($myCompositeContainer);
```

When the container is asked for a service using ```get()```, it will return it.  It will pass the Delegate Container
into the factory closure, so it is from here that any dependencies of your service will be retrieved.

You can use the basic `CompositeContainer` class provided by the library, if you need something to loop through various
delegate containers.

## Alternatives

Ultra-Lite Container was originally inspired by [Pimple](https://github.com/silexphp/Pimple), which still makes an
excellent DI container in PHP.  Container-Interop compliant wrappers are available.  Another excellent project,
[Picotainer](https://github.com/thecodingmachine/picotainer), is along similar lines, with the principle difference
being that the dependencies are defined at the time of instantiation of the container.  The
[Container Interop](https://github.com/container-interop/container-interop) team have prepared a full list of PHP DI
containers known to comply with the standard, so plenty of options are available.

## Installation

```json
"require": {
    "ultra-lite/container": "*"
}
```

## Contributions

Contributions welcome.

You can run the tests with ```./vendor/bin/behat -c tests/behat/behat.yml``` and ```./vendor/bin/phpspec r -c tests/phpspec/phpspec.yml```.

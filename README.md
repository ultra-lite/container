[![Build Status](https://travis-ci.org/ultra-lite/container.svg?branch=master)](https://travis-ci.org/ultra-lite/container)

# Ultra-Lite Container

An ultra-lightweight DI container.

Using lambda functions as factories for creating dependencies.  Inspired by Pimple DI.

Aims for full compliance with the Container-Interop standard, including the optional Delegate Lookup feature.

It is backwards-compatible with PHP 5.5.

## Usage

### Setting services


Add factory closures to the container like this:

```php
$container->set(
    'service-id',
    function (\Interop\Container\ContainerInterface $container) {
        return new \stdClass();
    }
);
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

## Installation

```json
"require": {
    "ultra-lite/container": "*"
}
```

## Contributions

Contributions welcome.

You can run the tests with ```./vendor/bin/behat -c tests/behat/behat.yml``` and ```./vendor/bin/phpspec r -c tests/phpspec/phpspec.yml```.

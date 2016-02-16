<?php
namespace UltraLite\Container;

use Interop\Container\ContainerInterface;
use UltraLite\Container\Exception\DiServiceNotFound;

class CompositeContainer implements ContainerInterface
{
    /** @var ContainerInterface[] */
    private $containers = [];

    public function get($serviceId)
    {
        foreach ($this->containers as $container) {
            if ($container->has($serviceId)) {
                return $container->get($serviceId);
            }
        }
        throw DiServiceNotFound::createFromServiceId($serviceId);
    }

    public function has($serviceId)
    {
        foreach ($this->containers as $container) {
            if ($container->has($serviceId)) {
                return true;
            }
        }
        return false;
    }

    public function addContainer(ContainerInterface $delegateContainer)
    {
        $this->containers[] = $delegateContainer;
    }
}

<?php
namespace UltraLite\Container;

use Psr\Container\ContainerInterface;
use UltraLite\Container\Exception\DiServiceNotFound;

class CompositeContainer implements ContainerInterface
{
    /** @var ContainerInterface[] */
    private $containers = [];

    /**
     * @param string $serviceId
     * @return mixed
     */
    public function get($serviceId)
    {
        foreach ($this->containers as $container) {
            if ($container->has($serviceId)) {
                return $container->get($serviceId);
            }
        }
        throw DiServiceNotFound::createFromServiceId($serviceId);
    }

    /**
     * @param string $serviceId
     * @return bool
     */
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

    public function addPriorityContainer(ContainerInterface $delegateContainer)
    {
        array_unshift($this->containers, $delegateContainer);
    }
}

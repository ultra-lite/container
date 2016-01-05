<?php
namespace UltraLite\Container;

use Interop\Container\ContainerInterface;
use UltraLite\Container\Exception\DiServiceNotFound;
use Interop\Container\Exception\NotFoundException;

class Container implements ContainerInterface
{
    /** @var \Closure[] */
    private $serviceFactories = [];

    /** @var array */
    private $services = [];

    /** @var ContainerInterface */
    private $delegateContainer;

    /**
     * Expects associative array like: ['service-id' => function (Container $c) {...}]
     */
    public function setServiceFactories(array $serviceFactories)
    {
        foreach ($serviceFactories as $serviceId => $serviceFactory) {
            $this->serviceFactories[$serviceId] = $serviceFactory;
            unset($this->services[$serviceId]);
        }
    }

    /**
     * @throws NotFoundException
     *
     * @param string $serviceId
     * @return mixed
     */
    public function get($serviceId)
    {
        if (!$this->has($serviceId)) {
            throw DiServiceNotFound::createFromServiceId($serviceId);
        }

        if (!isset($this->services[$serviceId])) {
            $this->services[$serviceId] = $this->getServiceFromFactory($serviceId);
        }

        return $this->services[$serviceId];
    }

    private function getServiceFromFactory(string $serviceId)
    {
        $serviceFactory = $this->serviceFactories[$serviceId];
        $containerToUseForDependencies = $this->delegateContainer ?: $this;
        return $serviceFactory($containerToUseForDependencies);
    }

    /**
     * @param string $serviceId
     * @return bool
     */
    public function has($serviceId)
    {
        return isset($this->serviceFactories[$serviceId]);
    }

    public function setDelegateContainer(ContainerInterface $delegateContainer)
    {
        $this->delegateContainer = $delegateContainer;
    }
}

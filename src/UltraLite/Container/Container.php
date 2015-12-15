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
     * @param string   $serviceId
     * @param \Closure $serviceFactory
     */
    public function set($serviceId, \Closure $serviceFactory)
    {
        $this->serviceFactories[$serviceId] = $serviceFactory;
        unset($this->services[$serviceId]);
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

    /**
     * @param string $serviceId
     * @return mixed
     */
    private function getServiceFromFactory($serviceId)
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

    /**
     * @param ContainerInterface $delegateContainer
     */
    public function setDelegateContainer(ContainerInterface $delegateContainer)
    {
        $this->delegateContainer = $delegateContainer;
    }
}

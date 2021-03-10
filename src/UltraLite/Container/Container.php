<?php
namespace UltraLite\Container;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use UltraLite\Container\Exception\DiServiceNotFound;

class Container implements ContainerInterface
{
    /** @var \Closure[] */
    private $serviceFactories = [];

    /** @var array */
    private $services = [];

    /** @var ContainerInterface */
    private $delegateContainer;

    /**
     * @param \Closure[] $serviceFactories
     */
    public function __construct(array $serviceFactories = [])
    {
        foreach ($serviceFactories as $serviceId => $serviceFactory) {
            $this->set($serviceId, $serviceFactory);
        }
    }

    public function set(string $serviceId, \Closure $serviceFactory)
    {
        $this->serviceFactories[$serviceId] = $serviceFactory;
        unset($this->services[$serviceId]);
    }

    public function configureFromFile(string $path)
    {
        foreach (require $path as $serviceId => $serviceFactory) {
            $this->set($serviceId, $serviceFactory);
        }
    }

    /**
     * @throws NotFoundExceptionInterface
     *
     * @return mixed
     */
    public function get(string $serviceId)
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
     * @return string[]
     */
    public function listServiceIds() : array
    {
        return array_keys($this->serviceFactories);
    }

    /**
     * @return mixed
     */
    private function getServiceFromFactory(string $serviceId)
    {
        $serviceFactory = $this->serviceFactories[$serviceId];
        $containerToUseForDependencies = $this->delegateContainer ?: $this;
        return $serviceFactory($containerToUseForDependencies);
    }

    /**
     * @return bool
     */
    public function has(string $serviceId)
    {
        return isset($this->serviceFactories[$serviceId]);
    }

    public function setDelegateContainer(ContainerInterface $delegateContainer)
    {
        $this->delegateContainer = $delegateContainer;
    }
}

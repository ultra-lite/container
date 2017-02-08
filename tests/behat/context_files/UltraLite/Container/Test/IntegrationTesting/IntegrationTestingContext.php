<?php
namespace UltraLite\Container\Test\IntegrationTesting;

use Behat\Behat\Context\Context;
use UltraLite\Container\Container;
use PHPUnit\Framework\Assert;

class IntegrationTestingContext implements Context
{
    /** @var Container */
    private $container;

    /** @var \Closure */
    private $factoryClosure;

    /** @var mixed */
    private $result;

    /** @var \Exception */
    private $exceptionThrown;

    /**
     * @Given I have an empty container
     */
    public function iHaveAnEmptyContainer()
    {
        $this->container = new Container();
    }

    /**
     * @Given I have a factory closure which returns a new :classname
     */
    public function iHaveAFactoryClosureWhichReturnsANew(string $classname)
    {
        $this->factoryClosure =
            function () use ($classname) {
                return new $classname;
            }
        ;
    }

    /**
     * @When I set the service ID :serviceId with my factory closure
     */
    public function iSetTheServiceIdWithMyFactoryClosure(string $serviceId)
    {
        $this->container->set($serviceId, $this->factoryClosure);
    }

    /**
     * @When I get the service ID :serviceId (again)
     */
    public function iGetTheServiceId(string $serviceId)
    {
        $this->result = $this->container->get($serviceId);
    }

    /**
     * @Then the result should be a :classname object
     */
    public function theResultShouldBeAObject(string $classname)
    {
        Assert::assertInstanceOf($classname, $this->result);
    }

    /**
     * @When I try to get the service ID :serviceId
     */
    public function iTryToGetTheServiceId(string $serviceId)
    {
        try {
            $this->container->get($serviceId);
        } catch (\Exception $exception) {
            $this->exceptionThrown = $exception;
        }
    }

    /**
     * @Then the resulting error should be a :exceptionType
     */
    public function theResultingErrorShouldBeA(string $exceptionType)
    {
        Assert::assertInstanceOf($exceptionType, $this->exceptionThrown);
    }

    /**
     * @When I add a property :propertyName to the result
     */
    public function iAddAPropertyToTheResult(string $propertyName)
    {
        $this->result->$propertyName = 1;
    }

    /**
     * @Then the result should have the property :propertyName on it
     */
    public function theResultShouldHaveThePropertyOnIt(string $propertyName)
    {
        Assert::assertObjectHasAttribute($propertyName, $this->result);
    }

    /**
     * @Given I have a config file at :pathToConfigFile
     */
    public function iHaveAConfigFileAt(string $pathToConfigFile)
    {
    }

    /**
     * @When I tell the container to read the config file at :pathToConfigFile
     */
    public function iTellTheContainerToReadTheConfigFileAt(string $pathToConfigFile)
    {
        $this->container->configureFromFile($pathToConfigFile);
    }
}

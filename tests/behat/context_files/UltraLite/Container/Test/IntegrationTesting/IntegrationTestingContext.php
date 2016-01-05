<?php
namespace UltraLite\Container\Test\IntegrationTesting;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use UltraLite\Container\Container;

class IntegrationTestingContext implements Context, SnippetAcceptingContext
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
    public function iHaveAFactoryClosureWhichReturnsANew($classname)
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
    public function iSetTheServiceIdWithMyFactoryClosure($serviceId)
    {
        $this->container->setServiceFactories([$serviceId => $this->factoryClosure]);
    }

    /**
     * @When I get the service ID :serviceId (again)
     */
    public function iGetTheServiceId($serviceId)
    {
        $this->result = $this->container->get($serviceId);
    }

    /**
     * @Then the result should be a :classname object
     */
    public function theResultShouldBeAObject($classname)
    {
        \PHPUnit_Framework_Assert::assertInstanceOf($classname, $this->result);
    }

    /**
     * @When I try to get the service ID :serviceId
     */
    public function iTryToGetTheServiceId($serviceId)
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
    public function theResultingErrorShouldBeA($exceptionType)
    {
        \PHPUnit_Framework_Assert::assertInstanceOf($exceptionType, $this->exceptionThrown);
    }

    /**
     * @When I add a property :propertyName to the result
     */
    public function iAddAPropertyToTheResult($propertyName)
    {
        $this->result->$propertyName = 1;
    }

    /**
     * @Then the result should have the property :propertyName on it
     */
    public function theResultShouldHaveThePropertyOnIt($propertyName)
    {
        \PHPUnit_Framework_Assert::assertObjectHasAttribute($propertyName, $this->result);
    }
}

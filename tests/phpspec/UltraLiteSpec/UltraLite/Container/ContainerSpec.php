<?php
namespace UltraLiteSpec\UltraLite\Container;

use PhpSpec\ObjectBehavior;
use Psr\Container\NotFoundExceptionInterface;
use UltraLite\Container\Container;
use Psr\Container\ContainerInterface;

/**
 * @mixin Container
 */
class ContainerSpec extends ObjectBehavior
{
    function it_is_standards_compliant()
    {
        $this->shouldHaveType(ContainerInterface::class);
    }

    function it_can_get_dependencies_from_factory_closures()
    {
        // ARRANGE
        $factoryClosure =
            function () {
                return new \stdClass();
            }
        ;

        // ACT
        $this->set('service-id', $factoryClosure);
        $result = $this->get('service-id');

        // ASSERT
        $result->shouldBeLike(new \stdClass);
    }

    function it_can_tell_if_it_has_things()
    {
        $this->has('service-id')->shouldBe(false);
        $this->set('service-id', function () {});
        $this->has('service-id')->shouldBe(true);
    }

    function it_throws_a_standards_compliant_exception_when_the_dependency_doesnt_exist()
    {
        $this->shouldThrow(NotFoundExceptionInterface::class)->during('get', ['service-id']);
    }

    function it_accepts_delegate_containers(ContainerInterface $delegateContainer)
    {
        // ARRANGE
        $factoryClosure =
            function (ContainerInterface $container) {
                return $container->get('a-dependency');
            }
        ;

        $this->set('a-service', $factoryClosure);

        // ACT
        $this->setDelegateContainer($delegateContainer);
        $this->get('a-service');

        // ASSERT
        $delegateContainer->get('a-dependency')->shouldHaveBeenCalled();
    }

    function it_accepts_services_in_constructor()
    {
        // ARRANGE
        $this->beConstructedWith([
            'service-id' => function () {
                return new \stdClass();
            },
        ]);

        // ACT
        $result = $this->get('service-id');

        // ASSERT
        $result->shouldBeLike(new \stdClass);
    }
}

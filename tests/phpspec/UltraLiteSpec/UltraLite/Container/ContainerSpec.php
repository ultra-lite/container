<?php
namespace UltraLiteSpec\UltraLite\Container;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use UltraLite\Container\Container;

/**
 * @mixin Container
 */
class ContainerSpec extends ObjectBehavior
{
    function it_is_standards_compliant()
    {
        $this->shouldHaveType('Interop\Container\ContainerInterface');
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
        $this->shouldThrow('\Interop\Container\Exception\NotFoundException')->during('get', ['service-id']);
    }
}

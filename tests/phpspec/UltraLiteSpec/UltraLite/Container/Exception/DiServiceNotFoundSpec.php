<?php
namespace UltraLiteSpec\UltraLite\Container\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use UltraLite\Container\Exception\DiServiceNotFound;

/**
 * @mixin DiServiceNotFound
 */
class DiServiceNotFoundSpec extends ObjectBehavior
{
    function it_is_an_exception()
    {
        $this->shouldHaveType('\Exception');
    }

    function it_is_standards_compliant()
    {
        $this->shouldHaveType('\Interop\Container\Exception\NotFoundException');
    }

    function it_has_a_named_constructor()
    {
        $this->beConstructedThrough('createFromServiceId', ['service-id']);
        $this->getMessage()->shouldBe('Service \'service-id\' requested from DI container, but not found.');
    }
}

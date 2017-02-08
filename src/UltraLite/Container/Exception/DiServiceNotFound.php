<?php
namespace UltraLite\Container\Exception;

use Interop\Container\Exception\NotFoundException;

class DiServiceNotFound extends \InvalidArgumentException implements NotFoundException
{
    /**
     * @param string $serviceId
     * @return DiServiceNotFound
     */
    public static function createFromServiceId(string $serviceId)
    {
        $message = "Service '$serviceId' requested from DI container, but not found.";
        return new static($message);
    }
}

<?php
namespace UltraLite\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;

class DiServiceNotFound extends \InvalidArgumentException implements NotFoundExceptionInterface
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

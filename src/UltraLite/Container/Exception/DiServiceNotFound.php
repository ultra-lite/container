<?php
namespace UltraLite\Container\Exception;

use Interop\Container\Exception\NotFoundException;

class DiServiceNotFound extends \InvalidArgumentException implements NotFoundException
{
    public static function createFromServiceId(string $serviceId): DiServiceNotFound
    {
        $message = "Service '$serviceId' requested from DI container, but not found.";
        return new static($message);
    }
}

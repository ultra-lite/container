<?php

return [
    'std-class' =>
        function (\Psr\Container\ContainerInterface $container) {
            return new \stdClass();
        }
];

<?php

namespace Framework\HTTP\Response\Encoder;

use ReflectionClass;
use ReflectionException;

class NormalizeAndDenormalize
{
    /**
     * @throws ReflectionException
     */
    public function denormalize(array $array, object $object): object
    {
        $reflectionClass = new ReflectionClass($object);

        foreach ($reflectionClass->getProperties() as $property) {
            $value = $array[$property->getName()];
            $reflectionClass->getProperty($property->getName())->setValue($object, $value);
        }

        return $object;
    }

    public function normalize(object $object): array
    {
        $array = [];
        $reflectionClass = new ReflectionClass($object);

        foreach ($reflectionClass->getProperties() as $property) {
            $array[$property->getName()] = $property->getValue($object);
        }

        return $array;
    }
}
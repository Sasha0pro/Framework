<?php

namespace Framework\HTTP\Response\Encoder;

use Framework\HTTP\Response\EncoderInterface;
use ReflectionException;

class JsonEncoder extends NormalizeAndDenormalize implements EncoderInterface
{
    public function serialize(object $object): string
    {
        $array = $this->normalize($object);

        return $this->encode($array);
    }

    /**
     * @throws ReflectionException
     */
    public function deserialize($formatValue, ?object $object): ?object
    {
        $array = $this->decode($formatValue);

        return $this->denormalize($array, $object);
    }

    public function encode(array $array): string
    {
        return json_encode($array);
    }

    public function decode($formatValue)
    {
        return json_decode($formatValue, true);
    }

}
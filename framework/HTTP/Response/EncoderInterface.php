<?php

namespace Framework\HTTP\Response;

interface EncoderInterface
{
    public function serialize(object $object);

    public function deserialize($formatValue, ?object $object);

    public function denormalize(array $array, object $object);

    public function normalize(object $object);
    public function encode(array $array);
    public function decode($formatValue);
}
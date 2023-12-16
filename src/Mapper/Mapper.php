<?php

namespace App\Mapper;

use App\Dto\Response;
use App\Entity\EntityInterface;
use ReflectionClass;
use ReflectionException;

class Mapper
{
    /**
     * @throws ReflectionException
     */
    public function toDto(array $output, EntityInterface $entity)
    {
        $responseDto = new ReflectionClass($output['class']);
        if ($responseDto->implementsInterface(Response::class) === false) {
            throw new ReflectionException('No dto response found: ' . $output['name']);
        }
        $construct = [];

        foreach ($responseDto->getProperties() as $property) {
            $getFunc = 'get' . ucfirst($property->name);
            $construct[] = $entity->$getFunc();
        }

        return $responseDto->newInstance(...$construct);
    }
}
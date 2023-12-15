<?php

namespace App\Mapper;

use ReflectionClass;
use ReflectionException;

class Mapper
{
    /**
     * @throws ReflectionException
     */
    public function toDto(ReflectionClass $dto, $entity)
    {
        $construct = [];

        foreach($dto->getProperties() as $property) {
            $getFunc = 'get' . ucfirst($property->name);
            $construct[] = $entity->$getFunc();
        }

        return $dto->newInstance(...$construct);
    }
}
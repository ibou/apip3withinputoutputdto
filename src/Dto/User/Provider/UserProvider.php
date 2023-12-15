<?php

namespace App\Dto\User\Provider;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\Operation;
use App\Dto\User\Response\UserCollectionResponse;
use App\Dto\User\Response\UserResponse;
use App\Dto\User\User;
use App\Entity\UserEntity;
use App\Mapper\Mapper;
use ArrayIterator;
use Doctrine\ORM\EntityNotFoundException;
use ReflectionClass;
use ReflectionException;

final class UserProvider implements ProviderInterface
{
    public function __construct(
        private readonly CollectionProvider $collectionProvider,
        private readonly ItemProvider $itemProvider,
        private readonly Mapper $mapper,
    ){}

    /**
     * {@inheritDoc}
     * @throws EntityNotFoundException|ReflectionException
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            $entities = $this->collectionProvider->provide($operation, $uriVariables, $context);

            /** @var array<UserResponse> $data */
            $data = [];
            foreach ($entities as $entity) {

                $data[] = ($entity instanceof UserEntity)
                    ? $this->mapper->toDto(new ReflectionClass(UserCollectionResponse::class), $entity)
                    : throw new EntityNotFoundException('User does not exist');
            }

            return ($entities instanceof Paginator)
                ? new TraversablePaginator(
                    new ArrayIterator($data),
                    $entities->getCurrentPage(),
                    $entities->getItemsPerPage(),
                    $entities->getTotalItems(),
                )
                : $data;
        }

        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        return $entity instanceof UserEntity
            ? $this->mapper->toDto(new ReflectionClass(UserResponse::class), $entity)
            : throw new EntityNotFoundException('User does not exist');
    }
}
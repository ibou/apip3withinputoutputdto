<?php

namespace App\Factory;

use App\Entity\UserEntity;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<UserEntity>
 *
 * @method        UserEntity|Proxy                     create(array|callable $attributes = [])
 * @method static UserEntity|Proxy                     createOne(array $attributes = [])
 * @method static UserEntity|Proxy                     find(object|array|mixed $criteria)
 * @method static UserEntity|Proxy                     findOrCreate(array $attributes)
 * @method static UserEntity|Proxy                     first(string $sortedField = 'id')
 * @method static UserEntity|Proxy                     last(string $sortedField = 'id')
 * @method static UserEntity|Proxy                     random(array $attributes = [])
 * @method static UserEntity|Proxy                     randomOrCreate(array $attributes = [])
 * @method static UserRepository|RepositoryProxy repository()
 * @method static UserEntity[]|Proxy[]                 all()
 * @method static UserEntity[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static UserEntity[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static UserEntity[]|Proxy[]                 findBy(array $attributes)
 * @method static UserEntity[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static UserEntity[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class UserFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return [
            'uuid' => Uuid::v6(),
            'email' => self::faker()->safeEmail,
            'password' => self::faker()->password(12),
            'roles' => ["ROLE_USER"],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function(UserEntity $user) {
                $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            })
        ;
    }

    protected static function getClass(): string
    {
        return UserEntity::class;
    }
}

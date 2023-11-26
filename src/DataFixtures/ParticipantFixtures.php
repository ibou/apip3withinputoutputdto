<?php

namespace App\DataFixtures;

use App\Factory\EventFactory;
use App\Factory\ParticipantFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ParticipantFactory::createMany(20, function() {
            return [
                'user' => UserFactory::random(),
                'event' => EventFactory::random(),
            ];
        });
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}

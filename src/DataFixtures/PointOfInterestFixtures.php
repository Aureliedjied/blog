<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\PointOfInterest;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PointOfInterestFixtures extends Fixture implements DependentFixtureInterface
{
    // Définir des constantes pour les types de point d'intérêt
    private const RESTAURANT = 'restaurant';
    private const HOTEL = 'hotel';
    private const ACTIVITY = 'activity';

    public function getDependencies()
    {
        return [ItineraryFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Créer des points d'intérêt fictifs
        for ($i = 0; $i < 20; $i++) {
            $poi = new PointOfInterest();
            $poi->setName($faker->sentence());
            $poi->setType($faker->randomElement([self::RESTAURANT, self::HOTEL, self::ACTIVITY]));
            $poi->setLatitude($faker->latitude);
            $poi->setLongitude($faker->longitude);

            // Associer le point d'intérêt à un itinéraire existant 
            $itineraryReference = "itinerary_" . rand(0, 4);
            $poi->setItinerary($this->getReference($itineraryReference));

            $manager->persist($poi);
        }

        $manager->flush();
    }
}

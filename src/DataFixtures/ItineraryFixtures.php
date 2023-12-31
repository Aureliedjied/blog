<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Itinerary;
use App\Entity\PointOfInterest;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ItineraryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Créer des itinéraires fictifs
        for ($i = 0; $i < 20; $i++) {
            $itinerary = new Itinerary();
            $itinerary->setTitle($faker->sentence());
            $itinerary->setDescription($faker->paragraph());

            // Associer l'itinéraire à un article existant (à adapter selon votre structure)
            for ($j = 0; $j < 5; $j++) {
                $pointOfInterest = new PointOfInterest();
                $pointOfInterest->setName("POI $j");
                $pointOfInterest->setType('Restaurant');
                $pointOfInterest->setLatitude(1.2345);
                $pointOfInterest->setLongitude(5.6789);

                $itinerary->addPointOfInterest($pointOfInterest);
            }
            $manager->persist($itinerary);
            $this->addReference("itinerary_$i", $itinerary);

            $manager->persist($itinerary);
        }

        $manager->flush();
    }
}

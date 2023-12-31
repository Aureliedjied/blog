<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\SocialShare;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SocialShareFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [ArticleFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Créer des partages sociaux fictifs
        for ($i = 0; $i < 20; $i++) {
            $socialShare = new SocialShare();
            $socialShare->setPlatform($faker->randomElement(['Facebook', 'Twitter', 'Instagram']));
            $socialShare->setLink($faker->url);
            $articleReference = "article_" . rand(0, 19);
            $socialShare->setArticle($this->getReference($articleReference));

            $manager->persist($socialShare);
        }

        $manager->flush();
    }
}

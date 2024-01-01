<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use App\Entity\Comment;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [UserFixtures::class, CategoryFixtures::class, ItineraryFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setAuthor($this->getReference('admin-user'));
            $article->setCategory($this->getReference('category-' . rand(0, '4')));
            $article->setTitle($faker->sentence());
            $article->setContent($faker->paragraph());
            $article->setSlug($faker->slug());

            $article->setItinerary($this->getReference('itinerary_0'));

            $manager->persist($article);

            $this->addReference("article_$i", $article);
        }

        $manager->flush();
        $this->loadComment($manager);
    }

    public function loadComment(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Créer 20 commentaires factices
        for ($i = 0; $i < 20; $i++) {
            $comment = new Comment();
            $comment->setAuthor($this->getReference('user-' . rand(0, 9)));
            $comment->setContent($faker->paragraph());
            $comment->setIsApproved(true);
            $comment->setCreatedAt(new \DateTime());
            // Associer le commentaire à un article existant 
            $comment->setArticle($this->getReference('article_' . $i));

            $manager->persist($comment);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures\Article;

use Faker\Factory;
use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence);
            $article->setContent($faker->paragraph);
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
            $comment->setAuthor($faker->name);
            $comment->setContent($faker->paragraph);
            // Associer le commentaire à un article existant (à adapter selon votre structure)
            $comment->setArticle($this->getReference('article_' . $i));

            $manager->persist($comment);
        }

        $manager->flush();
    }
}

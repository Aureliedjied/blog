<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Comment;
use Faker\Factory;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
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

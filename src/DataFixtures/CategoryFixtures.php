<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $categories = ['Sri Lanka', 'Vietnam', 'Japon', 'Philippines', 'Thailande'];

        foreach ($categories as $i => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setSlug($this->slugger->slug($categoryName)->lower());

            $manager->persist($category);
            $this->addReference('category-' . $i, $category);
        }

        $manager->flush();
    }
}

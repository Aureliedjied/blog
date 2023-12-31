<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $admin = new User();
        $admin->setFirstname('Admin');
        $admin->setLastname('Aurelie');
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);

        $plainPassword = $faker->password(8, 16);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, $plainPassword);
        $admin->setPassword($hashedPassword);

        $manager->persist($admin);
        $this->addReference('admin-user', $admin);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();

            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);

            $plainPassword = $faker->password(8, 16);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $manager->persist($user);
            $this->addReference('user-' . $i, $user);
        }

        $manager->flush();
    }
}

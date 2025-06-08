<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Project;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Contribution; 

class AppFixtures extends Fixture
{
    /**
     * @var Generator 
     */

    private Generator $faker;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->userPasswordHasher = $userPasswordHasher; 
        
    }


    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i <= 2; $i++)
        {
            $user = new User();
            $user->setLastname($this->faker->lastName());
            $user->setFirstname($this->faker->firstName());
            $user->setEmail($this->faker->email());
            $user->setPassword($this->userPasswordHasher->hashPassword($user, "pwd"));
            $manager->persist($user);

            $project = new Project();
            $project->setProjectname($this->faker->company())
                    ->setProjectimage($this->faker->image(null, 360, 360, 'animals', true))
            ->setDescripton($this->faker->paragraph(2))
            ->setGoalAmount($this->faker->randomNumber(6, true))
            ->setDuration("22");
            $manager->persist($project);

            $contrib = new Contribution();
            $contrib->setContributor($user); 
            $contrib->setProject($project); 
            $contrib->setAmount($this->faker->randomNumber(2, true)); 
            $manager->persist($contrib);
        }


        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    private $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void
    {
        echo "fixture commencée";


        $usersData = [
            [
                'email' => 'user@gmail.com',
                'password' => 'password123',
                'roles' => ['ROLE_USER'],
                'social_number' => '0000',
                'last_name' => 'Suicontan',
                'first_name' => 'Jean'
            ],
            [
                'email' => 'advisor@gmail.com',
                'password' => 'password123',
                'roles' => ['ROLE_ADVISOR'],
                'social_number' => '0000',
                'last_name' => 'Conseiller n°1'
            ],
            [
                'email' => 'validator@gmail.com',
                'password' => 'password123',
                'roles' => ['ROLE_VALIDATOR'],
                'social_number' => '0000',
                'last_name' => 'Agent n°1'
            ],
            [
                'email' => 'admin@gmail.com',
                'password' => 'password123',
                'roles' => ['ROLE_ADMIN'],
                'social_number' => '0000',
                'last_name' => 'admin'
            ],
        ];



        foreach ($usersData as $userData){
            $user = new User();
            $user->setEmail($userData['email']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
            $user->setPassword($hashedPassword);
            $user->setRoles($userData['roles']);
            $user->setSocialNumber($userData['social_number']);
            $user->setLastName($userData['last_name']);
            $user->setFirstName($userData['firstname'] ?? null);

            $manager->persist($user);
        }
        $manager->flush();
        echo "fixture terminée";
    }
}

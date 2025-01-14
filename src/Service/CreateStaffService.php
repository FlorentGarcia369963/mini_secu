<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateStaffService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function create(string $role, string $LastName, string $email, string $password) : void
    {
        $user = $this->userRepository->findOneBy((['email' => $email]));

        if(!$user){
            $user = new User;
            $user->setEmail($email);

            $password = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($password);
            $user->setSocialNumber('0000');
            $user->setLastName($LastName);
        }
        if(in_array($role, ['ROLE_ADVISOR' || 'ROLE_VALIDATOR' || 'ROLE_ADMIN'])){
            $user->setRoles([$role]);
        }else{
            throw new Exception('Rôle non reconnu');
        }

        $this->userRepository->save($user, true);
    }
}
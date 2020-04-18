<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('floky')
            ->setEmail('ludovicblondon@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'test'
            ))
            ->setOnline(false)
        ;

        $manager->persist($user);

        $user = new User();

        $user->setUsername('rollo')
            ->setEmail('ludovic.mmcreation@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'test'
            ))
            ->setOnline(false)
        ;
        $manager->persist($user);

        $manager->flush();
    }
}

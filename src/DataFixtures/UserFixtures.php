<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@dekpe.com');
        $admin->setFirstName('Admin');
        $admin->setLastName('Dekpe');
        $admin->setPhone('+33612345678');
        $admin->setTwitterHandle('@dekpe');
        $admin->setTwitterProfileImage('https://pbs.twimg.com/profile_images/1234567890/avatar.jpg');
        $admin->setRoles(['ROLE_ADMIN']);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin123'
        );
        $admin->setPassword($hashedPassword);

        $manager->persist($admin);

        // Créer un auteur exemple
        $author = new User();
        $author->setEmail('journaliste@dekpe.com');
        $author->setFirstName('Marie');
        $author->setLastName('Dupont');
        $author->setPhone('+33612345679');
        $author->setTwitterHandle('@mariedupont');
        $author->setTwitterProfileImage('https://pbs.twimg.com/profile_images/default_profile.jpg');
        $author->setRoles(['ROLE_USER']);

        $hashedPassword2 = $this->passwordHasher->hashPassword(
            $author,
            'author123'
        );
        $author->setPassword($hashedPassword2);

        $manager->persist($author);
        $manager->flush();

        // Stocker les références pour les utiliser dans AppFixtures
        $this->addReference('user-admin', $admin);
        $this->addReference('user-author', $author);
    }
}

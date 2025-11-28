<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email', 'Email'),
            TextField::new('firstName', 'Prénom'),
            TextField::new('lastName', 'Nom'),
            TelephoneField::new('phone', 'Téléphone'),
            ImageField::new('profileImage', 'Photo de profil')
                ->setBasePath('uploads/profiles')
                ->setUploadDir('public/uploads/profiles')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setHelp('Upload de la photo de profil'),
            TextField::new('twitterHandle', 'Twitter/X Handle')
                ->setHelp('Ex: @username'),
            ArrayField::new('roles', 'Rôles'),
            TextField::new('password', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->onlyOnForms()
                ->setRequired(false)
                ->setHelp('Laisser vide pour ne pas modifier le mot de passe'),
        ];
    }

    public function persistEntity($entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User && $entityInstance->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $entityInstance,
                $entityInstance->getPassword()
            );
            $entityInstance->setPassword($hashedPassword);
        }
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity($entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User && $entityInstance->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $entityInstance,
                $entityInstance->getPassword()
            );
            $entityInstance->setPassword($hashedPassword);
        }
        parent::updateEntity($entityManager, $entityInstance);
    }
}

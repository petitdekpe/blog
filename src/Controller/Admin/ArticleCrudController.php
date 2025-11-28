<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\EntityManagerInterface;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Article && is_string($entityInstance->getTags())) {
            $tagsString = $entityInstance->getTags();
            $tagsArray = array_map('trim', explode(',', $tagsString));
            $entityInstance->setTags(array_filter($tagsArray));
        }
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Article && is_string($entityInstance->getTags())) {
            $tagsString = $entityInstance->getTags();
            $tagsArray = array_map('trim', explode(',', $tagsString));
            $entityInstance->setTags(array_filter($tagsArray));
        }
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            SlugField::new('slug')->setTargetFieldName('title'),
            AssociationField::new('categories', 'Catégories')
                ->setFormTypeOption('multiple', true)
                ->formatValue(function ($value, $entity) {
                    $categories = $entity->getCategories();
                    $names = [];
                    foreach ($categories as $category) {
                        $names[] = $category->getName();
                    }
                    return implode(', ', $names);
                }),
            AssociationField::new('author', 'Auteur'),
            TextareaField::new('tags', 'Tags')
                ->setHelp('Entrez les tags séparés par des virgules (Ex: Article, À la une, Sport)')
                ->formatValue(function ($value) {
                    return is_array($value) ? implode(', ', $value) : '';
                }),
            TextareaField::new('excerpt', 'Extrait')->hideOnIndex(),
            TextEditorField::new('content', 'Contenu')->hideOnIndex(),
            ImageField::new('image', 'Image')
                ->setBasePath('uploads/images')
                ->setUploadDir('public/uploads/images')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            BooleanField::new('featured', 'À la une'),
            BooleanField::new('published', 'Publié'),
            DateTimeField::new('createdAt', 'Créé le')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Modifié le')->hideOnForm(),
        ];
    }
}

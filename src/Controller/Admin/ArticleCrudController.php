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

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
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
            TextField::new('tag', 'Tag')->setHelp('Ex: Article, À la une'),
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

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
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $article = new Article();
        $article->setTags([]);
        return $article;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Article) {
            $request = $this->container->get('request_stack')->getCurrentRequest();
            $tagsString = $request->request->all()['Article']['tagsInput'] ?? '';

            if (!empty($tagsString)) {
                $tagsArray = array_map('trim', explode(',', $tagsString));
                $entityInstance->setTags(array_filter($tagsArray));
            } else {
                $entityInstance->setTags([]);
            }
        }
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Article) {
            $request = $this->container->get('request_stack')->getCurrentRequest();
            $tagsString = $request->request->all()['Article']['tagsInput'] ?? '';

            if (!empty($tagsString)) {
                $tagsArray = array_map('trim', explode(',', $tagsString));
                $entityInstance->setTags(array_filter($tagsArray));
            } else {
                $entityInstance->setTags([]);
            }
        }
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        $context = $this->getContext();
        $article = $context ? $context->getEntity()->getInstance() : null;
        $tagsValue = '';

        if ($article instanceof Article && $article->getTags()) {
            $tagsValue = implode(', ', $article->getTags());
        }

        $tagsField = TextField::new('tagsInput', 'Tags')
            ->setHelp('Entrez les tags séparés par des virgules (Ex: Article, À la une, Sport)')
            ->setFormTypeOption('mapped', false)
            ->setFormTypeOption('data', $tagsValue)
            ->onlyOnForms();

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
            $tagsField,
            TextField::new('tagsDisplay', 'Tags')
                ->formatValue(function ($value, $entity) {
                    if ($entity instanceof Article && $entity->getTags()) {
                        return implode(', ', $entity->getTags());
                    }
                    return '';
                })
                ->onlyOnIndex(),
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

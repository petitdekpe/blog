<?php

namespace App\Controller\Admin;

use App\Entity\Podcast;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class PodcastCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Podcast::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextareaField::new('embedUrl', 'URL Embed Spotify')
                ->setHelp('Collez l\'URL d\'embed Spotify complète (ex: https://open.spotify.com/embed/episode/...)'),
            BooleanField::new('isPublished', 'Publié'),
            DateTimeField::new('createdAt', 'Date d\'ajout')->hideOnForm(),
        ];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Récupérer les utilisateurs créés dans UserFixtures
        $author = $this->getReference('user-author', User::class);

        // Création des catégories
        $categories = [
            ['name' => 'France', 'slug' => 'france', 'icon' => 'flag'],
            ['name' => 'International', 'slug' => 'international', 'icon' => 'globe'],
            ['name' => 'Environnement', 'slug' => 'environnement', 'icon' => 'leaf'],
            ['name' => 'Technologie', 'slug' => 'technologie', 'icon' => 'laptop'],
            ['name' => 'Culture', 'slug' => 'culture', 'icon' => 'ticket'],
            ['name' => 'Santé', 'slug' => 'sante', 'icon' => 'heartbeat'],
            ['name' => 'Économie', 'slug' => 'economie', 'icon' => 'futbol'],
            ['name' => 'Sport', 'slug' => 'sport', 'icon' => 'futbol'],
        ];

        $categoryObjects = [];
        foreach ($categories as $categoryData) {
            $category = new Category();
            $category->setName($categoryData['name']);
            $category->setSlug($categoryData['slug']);
            $category->setIcon($categoryData['icon']);
            $manager->persist($category);
            $categoryObjects[] = $category;
        }

        // Création des articles
        $articles = [
            [
                'title' => 'Grenoble : un adolescent de 12 ans grièvement blessé par balle sur un point de deal',
                'categories' => [0], // France
                'excerpt' => 'Un jeune de 12 ans a été grièvement blessé par balle dans la métropole grenobloise lors d\'un règlement de comptes entre groupes de trafiquants.',
                'content' => '<p>Les fusillades dans le cadre de règlements de comptes entre groupes de trafiquants de drogue ne sont pas rares dans la capitale iséroise et certaines de ses banlieues.</p><p>En 2024, la place Saint-Bruno, au cœur de Chorier-Berriat, avait été le théâtre de plusieurs fusillades. Mais en septembre, "des habitants sont venus dire que leur vie avait changé depuis l\'an dernier", avait assuré la préfète de l\'Isère Catherine Séguin.</p>',
                'tag' => 'Article',
                'isFeatured' => true,
                'isPublished' => true,
            ],
            [
                'title' => 'Ukraine : que contient l\'accord signé par Emmanuel Macron et Volodymyr Zelensky ?',
                'categories' => [1, 0], // International + France
                'excerpt' => 'Emmanuel Macron et Volodymyr Zelensky ont signé un accord bilatéral de sécurité entre la France et l\'Ukraine.',
                'content' => '<p>Cet accord prévoit un soutien militaire et économique de la France à l\'Ukraine sur le long terme. Il s\'inscrit dans le cadre de la stratégie européenne de défense face à la menace russe.</p>',
                'tag' => 'À la une',
                'isFeatured' => false,
                'isPublished' => true,
            ],
            [
                'title' => 'Le procès du feu d\'artifice qui avait tué un frère et une sœur à Cholet s\'est ouvert',
                'categories' => [0], // France
                'excerpt' => 'Le procès de l\'accident tragique qui avait coûté la vie à deux enfants lors d\'un feu d\'artifice à Cholet a commencé.',
                'content' => '<p>En juillet 2020, un feu d\'artifice organisé lors d\'une fête privée a tragiquement tourné court. Deux enfants, un frère et une sœur, ont perdu la vie dans cet accident dramatique.</p>',
                'tag' => 'Article',
                'isFeatured' => false,
                'isPublished' => true,
            ],
            [
                'title' => 'Prud\'hommes : le PSG réclame 180 millions d\'euros à Kylian Mbappé',
                'categories' => [7], // Sport
                'excerpt' => 'Le Paris Saint-Germain a porté son différend avec Kylian Mbappé devant le conseil de prud\'hommes, réclamant 180 millions d\'euros.',
                'content' => '<p>Le conflit entre le PSG et son ancienne star Kylian Mbappé prend une tournure judiciaire. Le club parisien réclame une somme considérable à l\'attaquant, désormais joueur du Real Madrid.</p>',
                'tag' => 'Article',
                'isFeatured' => false,
                'isPublished' => true,
            ],
            [
                'title' => 'Urssaf : le service Pajemploi victime d\'un vol de données, jusqu\'à 500 000 comptes concernés',
                'categories' => [3], // Technologie
                'excerpt' => 'Le service Pajemploi de l\'Urssaf a été victime d\'une cyberattaque massive, compromettant les données de centaines de milliers d\'utilisateurs.',
                'content' => '<p>Cette cyberattaque représente une menace sérieuse pour la sécurité des données personnelles de nombreux employeurs et assistants maternels utilisant le service Pajemploi.</p>',
                'tag' => 'Article',
                'isFeatured' => false,
                'isPublished' => true,
            ],
            [
                'title' => 'La Pologne dénonce le "sabotage" d\'une voie ferroviaire reliant l\'Ukraine à l\'Europe',
                'categories' => [1], // International
                'excerpt' => 'Les autorités polonaises ont découvert un acte de sabotage sur une ligne ferroviaire stratégique reliant l\'Ukraine au reste de l\'Europe.',
                'content' => '<p>Cette voie ferrée est cruciale pour l\'acheminement de l\'aide humanitaire et militaire vers l\'Ukraine. Le sabotage pourrait avoir des implications géopolitiques importantes.</p>',
                'tag' => 'Article',
                'isFeatured' => false,
                'isPublished' => true,
            ],
            [
                'title' => 'Après un premier refus, Shein convoqué le 26 novembre devant la commission parlementaire',
                'categories' => [6, 2], // Économie + Environnement
                'excerpt' => 'Le géant de la fast-fashion Shein devra finalement répondre aux questions des parlementaires français.',
                'content' => '<p>Après avoir initialement refusé de comparaître, Shein a finalement accepté de se présenter devant la commission parlementaire pour répondre aux questions sur ses pratiques commerciales et environnementales.</p>',
                'tag' => 'Article',
                'isFeatured' => false,
                'isPublished' => true,
            ],
            [
                'title' => 'Climat : les émissions de CO2 atteignent un niveau record en 2024',
                'categories' => [2], // Environnement
                'excerpt' => 'Les émissions mondiales de dioxyde de carbone ont atteint un nouveau record historique cette année, selon les dernières données scientifiques.',
                'content' => '<p>Malgré les engagements pris lors des COP successives, les émissions de gaz à effet de serre continuent d\'augmenter, mettant en péril les objectifs de l\'Accord de Paris.</p>',
                'tag' => 'Article',
                'isFeatured' => false,
                'isPublished' => true,
            ],
            [
                'title' => 'L\'intelligence artificielle révolutionne la médecine : diagnostic plus rapide et précis',
                'categories' => [5, 3], // Santé + Technologie
                'excerpt' => 'Les avancées en intelligence artificielle permettent désormais d\'améliorer significativement la précision des diagnostics médicaux.',
                'content' => '<p>Des algorithmes d\'IA peuvent désormais détecter certaines maladies plus rapidement et avec plus de précision que les méthodes traditionnelles, ouvrant de nouvelles perspectives pour la médecine.</p>',
                'tag' => 'Article',
                'isFeatured' => false,
                'isPublished' => true,
            ],
            [
                'title' => 'Festival de Cannes 2025 : les premiers films en compétition dévoilés',
                'categories' => [4], // Culture
                'excerpt' => 'Le Festival de Cannes a dévoilé les premiers films qui seront en compétition pour la Palme d\'Or 2025.',
                'content' => '<p>Cette nouvelle édition du festival s\'annonce exceptionnelle avec une sélection prometteuse de films français et internationaux qui seront présentés sur la Croisette en mai prochain.</p>',
                'tag' => 'Article',
                'isFeatured' => false,
                'isPublished' => true,
            ],
        ];

        foreach ($articles as $articleData) {
            $article = new Article();
            $article->setTitle($articleData['title']);
            $article->setSlug($this->slugify($articleData['title']));

            // Add multiple categories
            foreach ($articleData['categories'] as $categoryIndex) {
                $article->addCategory($categoryObjects[$categoryIndex]);
            }

            $article->setExcerpt($articleData['excerpt']);
            $article->setContent($articleData['content']);
            $article->setTag($articleData['tag']);
            $article->setFeatured($articleData['isFeatured']);
            $article->setPublished($articleData['isPublished']);
            $article->setCreatedAt(new \DateTimeImmutable('-' . rand(1, 30) . ' days'));
            $article->setAuthor($author);

            $manager->persist($article);
        }

        $manager->flush();
    }

    private function slugify(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}

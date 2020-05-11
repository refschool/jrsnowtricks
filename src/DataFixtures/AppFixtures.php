<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Figure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadCategories($manager);
        $manager->flush();
        $this->loadFigures($manager);
        $manager->flush();
    }

    private function loadCategories(ObjectManager $manager): void
    {
        foreach ($this->getCategoryData() as $index => $name) {
            $category = new Category;
            $category->setName($name);

            $manager->persist($category);
        }
    }

    private function loadFigures(ObjectManager $manager)
    {
        foreach ($this->getFiguresData() as $figureData) {
            $figure = new Figure;
            $category = $manager->getRepository(Category::class)->findOneByName($figureData['category']);
            $figure->setName($figureData['name'])->setSlug($figureData['slug'])->setCreatedAt(new \DateTime($figureData['createdAt']))->setDescription($figureData['description'])->setCategory($category);
            $manager->persist($figure);
        }
    }

    private function getCategoryData(): array
    {
        return [
            'Straight airs',
            'Grabs',
            'Spins',
            'Flips',
            'Inverted hand plants',
            'Slides',
            'Stalls',
            'Tweaks',
            'Miscellaneous',
        ];
    }

    private function getFiguresData(): array
    {
        return [
            [
                'name' =>'Ollie',
                'slug' => 'Ollie',
                'description' => 'Un saut tout simple.',
                'category' => 'Straight airs',
                'createdAt' => '20-12-1982 17:20:00',
                ],
            [
                'name' => 'Nosegrab',
                'slug' => 'Nosegrab',
                'description' => 'attraper la pointe avant de son snowbard avec une de ses mains.',
                'category' => 'Grabs',
                'createdAt' => '11-09-2001 09:40:50',
            ]

        ];
    }
}

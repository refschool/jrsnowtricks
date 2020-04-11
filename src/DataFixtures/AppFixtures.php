<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadCategories($manager);

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
}

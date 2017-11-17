<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Category;

class LoadCategory extends Fixture implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $category1 = new Category();
    $category1->setName('Développement web');

    $category2 = new Category();
    $category2->setName('Développement mobile');

    $category3 = new Category();
    $category3->setName('Graphisme');

    $category4 = new Category();
    $category4->setName('Intégration');

    $category5 = new Category();
    $category5->setName('Réseau');

    $manager->persist($category1);
    $manager->persist($category2);
    $manager->persist($category3);
    $manager->persist($category4);
    $manager->persist($category5);

    $this->addReference('category1', $category1);
    $this->addReference('category2', $category2);
    $this->addReference('category3', $category3);
    $this->addReference('category4', $category4);
    $this->addReference('category5', $category5);

    $manager->flush();
  }
}

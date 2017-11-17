<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Skill;

class LoadSkill extends Fixture implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $skill1 = new Skill();
    $skill1->setName('PHP');

    $skill2 = new Skill();
    $skill2->setName('Symfony');

    $skill3 = new Skill();
    $skill3->setName('C++');

    $skill4 = new Skill();
    $skill4->setName('Java');

    $skill5 = new Skill();
    $skill5->setName('Photoshop');

    $skill6 = new Skill();
    $skill6->setName('Blender');

    $skill7 = new Skill();
    $skill7->setName('Bloc-note');

    $this->addReference('skill1', $skill1);
    $this->addReference('skill2', $skill2);
    $this->addReference('skill3', $skill3);
    $this->addReference('skill4', $skill4);
    $this->addReference('skill5', $skill5);
    $this->addReference('skill6', $skill6);
    $this->addReference('skill7', $skill7);

    $manager->persist($skill1);
    $manager->persist($skill2);
    $manager->persist($skill3);
    $manager->persist($skill4);
    $manager->persist($skill5);
    $manager->persist($skill6);
    $manager->persist($skill7);

    $manager->flush();
  }
}

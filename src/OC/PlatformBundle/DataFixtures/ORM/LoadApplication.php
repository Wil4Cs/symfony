<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Application;

class LoadApplication extends Fixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $application1 = new Application();
        $application1->setAuthor('Marine');
        $application1->setContent("J'ai toutes les qualités requises.");
        $application1->setAdvert($this->getReference('advert1'));

        $application2 = new Application();
        $application2->setAuthor('Pierre');
        $application2->setContent("Je suis très motivé.");
        $application2->setAdvert($this->getReference('advert1'));

        $manager->persist($application1);
        $manager->persist($application2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LoadAdvert::class,
        );
    }
}
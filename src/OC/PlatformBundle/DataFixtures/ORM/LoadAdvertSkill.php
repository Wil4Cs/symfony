<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\AdvertSkill;

class LoadAdvertSkill extends Fixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $listSkills = array(
            $this->getReference('skill1'),
            $this->getReference('skill2'),
            $this->getReference('skill3'),
            $this->getReference('skill4'),
            $this->getReference('skill5'),
            $this->getReference('skill6'),
            $this->getReference('skill7')
        );

        foreach ($listSkills as $skill)
        {
            $advertSkill = new AdvertSkill();
            $advertSkill->setLevel('Expert');
            $advertSkill->setAdvert($this->getReference('advert1'));
            $advertSkill->setSkill($skill);

            $manager->persist($advertSkill);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LoadAdvert::class,
        );
    }
}
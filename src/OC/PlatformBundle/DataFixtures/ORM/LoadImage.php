<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Image;

class LoadImage extends Fixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Creation d'une image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Job de rêve');

        $manager->persist($image);
        $manager->flush();

        $this->addReference('advert-image', $image);
    }
}
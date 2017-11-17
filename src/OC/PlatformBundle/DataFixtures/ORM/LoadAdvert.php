<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Advert;

class LoadAdvert extends Fixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $advert1 = new Advert();
        $advert1->setImage($this->getReference('advert-image'));
        $advert1->setTitle('Recherche développpeur Symfony');
        $advert1->setAuthor('Alexandre');
        $advert1->setContent('Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…');
        $advert1->addCategory($this->getReference('category1'));
        $advert1->addCategory($this->getReference('category2'));

        $advert2 = new Advert();
        $advert2->setImage(null);
        $advert2->setTitle('Mission de webmaster');
        $advert2->setAuthor('Hugo');
        $advert2->setContent('Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…');
        $advert2->addCategory($this->getReference('category3'));
        $advert2->addCategory($this->getReference('category4'));

        $advert3 = new Advert();
        $advert3->setImage(null);
        $advert3->setTitle('Offre de stage webdesigner');
        $advert3->setAuthor('Mathieu');
        $advert3->setContent('Nous proposons un poste pour webdesigner. Blabla…');
        $advert3->addCategory($this->getReference('category5'));

        $this->addReference('advert1', $advert1);

        $manager->persist($advert1);
        $manager->persist($advert2);
        $manager->persist($advert3);

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            LoadImage::class,
            LoadCategory::class,
        );
    }
}
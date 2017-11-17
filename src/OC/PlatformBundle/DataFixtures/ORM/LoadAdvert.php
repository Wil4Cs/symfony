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
        $listAdverts = array(
            array(
                'image_id'=> $this->getReference('advert-image'),
                'title'   => 'Recherche développpeur Symfony',
                'author'  => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…'),
            array(
                'image_id'=> null,
                'title'   => 'Mission de webmaster',
                'author'  => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…'),
            array(
                'image_id'=> null,
                'title'   => 'Offre de stage webdesigner',
                'author'  => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…'),
        );

        foreach ($listAdverts as $a)
        {
            $advert = new Advert();
            $advert->setImage($a['image_id']);
            $advert->setTitle($a['title']);
            $advert->setAuthor($a['author']);
            $advert->setContent($a['content']);
            $manager->persist($advert);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            LoadImage::class,
        );
    }
}
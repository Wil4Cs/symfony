<?php

namespace OC\PlatformBundle\Purge;

use Doctrine\ORM\EntityManagerInterface;

class AdvertPurge
{
    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function purge($days)
    {
        // http://php.net/manual/fr/datetime.formats.relative.php
        $date = new \Datetime($days.' days ago');

        $entityManager = $this->em;

        $advertRepository = $entityManager->getRepository('OCPlatformBundle:Advert');

        $listAdvertsToDelete = $advertRepository->getOutdatedAdvert($date);


        foreach ($listAdvertsToDelete as $advert)
        {
            $entityManager->remove($advert);
        }

        $entityManager->flush();
    }
}
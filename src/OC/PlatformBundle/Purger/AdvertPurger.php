<?php
// src/OC/PlatformBundle/Purger/AdvertPurger.php

namespace OC\PlatformBundle\Purger;

use Doctrine\ORM\EntityManagerInterface;

class AdvertPurger
{
  /**
   * @var EntityManagerInterface
   */
  private $em;

  // On injecte l'EntityManager
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

      $listAdvertsToDelete = $advertRepository->getAdvertsBefore($date);

      foreach ($listAdvertsToDelete as $advert)
      {
          $entityManager->remove($advert);
      }

      $entityManager->flush();
  }
}

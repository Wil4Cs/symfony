<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{
  public function indexAction($page)
  {
    if ($page < 1) {
      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    }

    $nbPerPage = $this->container->getParameter('nb_per_page');

    $listAdverts = $this->getDoctrine()
        ->getManager()
        ->getRepository('OCPlatformBundle:Advert')
        ->getAdverts($page, $nbPerPage);

      // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
      $nbPages = ceil(count($listAdverts) / $nbPerPage);

      // Si la page n'existe pas, on retourne une 404
      if ($page > $nbPages) {
          throw $this->createNotFoundException("La page ".$page." n'existe pas.");
      }

    return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts,
        'nbPages'     => $nbPages,
        'page'        => $page
    ));

  }

  public function viewAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em
        ->getRepository('OCPlatformBundle:Advert')
        ->find($id);

    // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
    // ou null si l'id $id n'existe pas, d'où ce if :
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On avait déjà récupéré la liste des candidatures
    $listApplications = $em
      ->getRepository('OCPlatformBundle:Application')
      ->findBy(array('advert' => $advert))
    ;

    // On récupère maintenant la liste des AdvertSkill
    $listAdvertSkills = $em
      ->getRepository('OCPlatformBundle:AdvertSkill')
      ->findBy(array('advert' => $advert))
    ;

    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
      'advert'           => $advert,
      'listApplications' => $listApplications,
      'listAdvertSkills' => $listAdvertSkills,
    ));
  }

  public function addAction(Request $request)
  {
      // On crée un objet Advert
      $advert = new Advert();

      // On crée le FormBuilder grâce au service form factory
      $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $advert);

      // On ajoute les champs de l'entité que l'on veut à notre formulaire
      $formBuilder
          ->add('date',      DateType::class)
          ->add('title',     TextType::class)
          ->add('content',   TextareaType::class)
          ->add('author',    TextType::class)
          ->add('published', CheckboxType::class)
          ->add('save',      SubmitType::class)
      ;
      // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard

      // À partir du formBuilder, on génère le formulaire
      $form = $formBuilder->getForm();

      // On passe la méthode createView() du formulaire à la vue
      // afin qu'elle puisse afficher le formulaire toute seule
      return $this->render('OCPlatformBundle:Advert:add.html.twig', array(
          'form' => $form->createView(),
      ));
  }

  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
    }

    return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
      'advert' => $advert
    ));
  }

  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On boucle sur les catégories de l'annonce pour les supprimer
    foreach ($advert->getCategories() as $category) {
      $advert->removeCategory($category);
    }

    // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
    // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine

    // On déclenche la modification
    $em->flush();
    
    return $this->render('OCPlatformBundle:Advert:delete.html.twig');
  }

  public function menuAction($limit)
  {
      $em = $this->getDoctrine()->getManager();

    // On fixe en dur une liste ici, bien entendu par la suite on la récupérera depuis la BDD !
    $listAdverts = $em->getRepository('OCPlatformBundle:Advert')->findBy(
        array(),
        array('date' => 'desc'),
        $limit,
        0
    );

    return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      'listAdverts' => $listAdverts
    ));
  }

    public function purgeAction($days)
    {
        $cleaner = $this->get('oc_platform.purge.advert');
        $cleaner->purge($days);
        return $this->redirectToRoute('oc_platform_home');
    }
}

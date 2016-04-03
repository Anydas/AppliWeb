<?php

// src/appliwebBundle/Controller/AdvertController.php

namespace appliwebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use OCUserBundle\Entity\User;
use appliwebBundle\Entity\Cat;
use appliwebBundle\Entity\Trick;
use appliwebBundle\Entity\Cat_goodies;
use appliwebBundle\Entity\Goodies;
use appliwebBundle\Entity\Image;
use appliwebBundle\Entity\Vote_user;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class AdvertController extends Controller
{//index
  public function indexAction(Request $request)
  { //aucun traitement on va direct a la vue
    $content = $this
    ->get('templating')
    ->render('appliwebBundle:Advert:index.html.twig', array(
      'page' => 'index'
    ));
    return new Response($content);

  }


//page d'affichage des chats (non admin)
  public function catlistAction(Request $req)
  { //création d'un formulaire avec une liste de chats
    //va permettre de renvoyé vers le bon chats lorsque l'user le voudra
    $defaultData = array('message' => 'Type your message here');
    $form = $this->createFormBuilder($defaultData)
    ->add('cat_name', 'entity', array(
      'class'    => 'appliwebBundle:Cat',
      'property' => 'French_name',
      'multiple' => false))
      ->add('send', 'submit')
      ->getForm();

      $form->handleRequest($req);
      //lorsque le formulaire est valide
      if ($form->isValid()) {
        // on recupere les donnée du formulaire
        $data = $form->getData();
        //on redirige vers la page du chat
        $content = new RedirectResponse('infocat?chat='.$data['cat_name']->getFrenchName());
      }else{
        /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
        //accé au repository  cat
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Cat')
        ;
        //on recupere la liste de tous les chats publié
        $listCat = $repository->findByIsPublish(1);

        //  $listCat = $repository->findAll();
        //on renvoie tout vers la vue
        $content = $this
        ->get('templating')
        ->render('appliwebBundle:Advert:catlist.html.twig', array(
          'listCat' => $listCat,
          'page' => 'cat-list',
          'form' => $form->createView()
          )
        );}
        return new Response($content);

      }



  //affiche un chat
      public function infocatAction(Request $req)
      {

        //on recupere l'id du chat a afficher
        $tag = $req->query->get('chat');

        /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
        //accé au repository cat
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Cat')
        ;
        //accé au repository trick
        $rep = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Trick')
        ;
        //accé au repository user
        $repp = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('OCUserBundle:User')
        ;
        //on recupere tous les users
        $user=  $repp->findAll();
        //on recupere le chat a afficher
        $cat = $repository->findOneByFrench_name($tag);
        //on recupere toute les astuces sur ce chat
        $trick = $rep->findByIdCat($cat->getId());

        //on renvoie tout a la vue
        $content = $this
        ->get('templating')
        ->render('appliwebBundle:Advert:infocat.html.twig', array(
          'nom' => $cat,
          'listTrick'=> $trick,
          'listUser' => $user,
          'page' => 'cat-list'
        )
      );
      return new Response($content);

    }

//affiche les foods
    public function foodAction()
    {



      /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
      //accé au repository food
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('appliwebBundle:Food')
      ;
      //on recupere tout les food
      $listFood = $repository->findAll();
      //$food = $repository->findByName('Sashimi');
      //on renvoie le resultat a la vue
      $content = $this
      ->get('templating')
      ->render('appliwebBundle:Advert:food.html.twig', array(
        'listFood' => $listFood,
        'page' => 'food'
      )
    );
    return new Response($content);

  }
//affiche les goodies
  public function goodiesAction()
  {


    /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
    //acce au repository goodies
    $repository = $this
    ->getDoctrine()
    ->getManager()
    ->getRepository('appliwebBundle:Goodies')
    ;
    //on recupere tous les goodies
    $listGoodies = $repository->findAll();
    //on renvoie tout a la vue
    $content = $this
    ->get('templating')
    ->render('appliwebBundle:Advert:goodies.html.twig', array(
      'listGoodies' => $listGoodies,
      'page' => 'goodies'
    )
  );
  return new Response($content);

}
      //affiche les astuces
      public function trickAction(Request $req)
      {

        //vote pour une astuce
        if (null !== $req->query->get('votegid'))
        {  //accé au repository trick
          $rep = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('appliwebBundle:Trick')
          ;
          //on recupere le manager
          $em = $this->getDoctrine()->getManager();
          //on recupere l'astuce correspondant
          $trick = $rep->findOneById($req->query->get('votegid'));
          //on recupere le nombre de j'aime actuel
          $nblike= $trick->getNbLike();
          //on incremente de 1
          $trick->setNbLike($nblike+1);
          //on sauvegarde dans la table vote user que
          // l'user courrant a voté pour cette astuce
          $vote=new Vote_user();
          $vote->setIdUser($this->container->get('security.context')->getToken()->getUser()->getId());
          $vote->setIdTrick($trick->getId());
          //on persiste les deux objets
          $em->persist($trick);
          $em->persist($vote);
          //on sauvegarde dans la bdd
          $em->flush();

        }
        //vote contre une astuce
        if (null !== $req->query->get('votebid'))
        {  //accé au repository
          $rep = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('appliwebBundle:Trick')
          ;
          //on recupere le manager
          $em = $this->getDoctrine()->getManager();
          //on recupere l'astuce pour laquelle on veux voter
          $trick = $rep->findOneById($req->query->get('votebid'));
          //on recupere le nombre de je n'aime pas
          $nblike= $trick->getNbDislike();
          //on incremente la valeur
          $trick->setNbDislike($nblike+1);
          //on sauvegarde dans la table vote user que
          // l'user courrant a voté pour cette astuce
          $vote=new Vote_user();
          $vote->setIdUser($this->container->get('security.context')->getToken()->getUser()->getId());
          $vote->setIdTrick($trick->getId());
          //on persiste les deux objets
          $em->persist($vote);
          $em->persist($trick);
          //on save tout dans la bdd
          $em->flush();

        }
        /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
        // accé au repository trick
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Trick')
        ;
        // accé au repository cat
        $repositorys = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Cat')
        ;
        // accé au repository user
        $repositoryss = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('OCUserBundle:User')
        ;
        //acce au repository vote_user
        $repos = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Vote_user')
        ;
        //on recupere l'user courrant
        $user= $this->container->get('security.context')->getToken()->getUser();
        //on recupere les astuce publié
        $listTrick = $repository->findByIsPublish(1);
        //on recupere les chats
        $listCat = $repositorys->findAll();
        //on recupere tous les user
        $listUser = $repositoryss->findAll();
        //si l'user courant est connécté
        if($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
          //on recupere toute les astuces pour lequels il a voté
        $listVote = $repos->findByIdUser($user->getId());
        //on renvoie tous a la vue
        $content = $this
        ->get('templating')
        ->render('appliwebBundle:Advert:trick.html.twig', array(
          'listTrick' => $listTrick,
          'listCat' => $listCat,
          'listUser' => $listUser,
          'listVote' => $listVote,
          'currentUser' => $user,
          'page' => 'trick'
        )
      );}else{
        //on renvoie tous a la vue
        $content = $this
        ->get('templating')
        ->render('appliwebBundle:Advert:trick.html.twig', array(
          'listTrick' => $listTrick,
          'listCat' => $listCat,
          'listUser' => $listUser,
          'currentUser' => $user,
          'page' => 'trick'
        )
      );
      }
      return new Response($content);

    }




  }?>

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
use appliwebBundle\Entity\user;
use appliwebBundle\Entity\Cat;
use appliwebBundle\Entity\Trick;
use appliwebBundle\Entity\Cat_goodies;
use appliwebBundle\Entity\Goodies;
use appliwebBundle\Entity\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AdminController extends Controller
{
  //fonction de vue des utilisateurs et de ban
  public function userAction(Request $req)
  {
      //on recupere l'id de l'utilisateur que l'on veut ban passé en param
      //grace a la methode get
      if (null !== $req->query->get('userid'))
      {
        //accé au repository User
        $rep = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('OCUserBundle:User')
        ;
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        //on recupere l'user defini par l'id userid
        $user = $rep->findOneById($req->query->get('userid'));
        //on place son attribut locked à true
        $user->setLocked(1);
        //on flush tout dans la bdd
        $em->flush();

      }
      //on recupere l'id de l'utilisateur que l'on veut deban passé en param
      //grace a la methode get
      if (null !== $req->query->get('useriddeb'))
      {   // accé au repository user
         $rep = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('OCUserBundle:User')
        ;
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        //on recupere l'user defini par l'id useriddeb
        $user = $rep->findOneById($req->query->get('useriddeb'));
        //on place son attribut locked à false
        $user->setLocked(0);
        //on flush tout dans la bdd
        $em->flush();

      }
      // accé au repository user
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('OCUserBundle:User')
      ;
      // on recupere tous les utilisateurs
      $listuser = $repository->findAll();
      // on renvoie les données pour la vue
      $content = $this
      ->get('templating')
      ->render('appliwebBundle:Admin:user.html.twig', array(
        'page' => 'user',
        'listUser' => $listuser
      ));
      return new Response($content);

    }
    // fonction d'affichage des chats
    public function catlistAction(Request $req)
    {

      //on recupere l'id du chat que l'on veut supprimer
      //grace a la methode get
        if (null !== $req->query->get('catid'))
        {
          // accé au repository cat
          $rep = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('appliwebBundle:Cat')
          ;
            // accé au repository trick
          $repos = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('appliwebBundle:Trick')
          ;
          // On récupère l'EntityManager
          $em = $this->getDoctrine()->getManager();
          //On recupere le chat correspondant à l'id
          $cat = $rep->findOneById($req->query->get('catid'));
          //on recupere toute les atuces de ce chat
          $listtrick = $repos->findByIdCat($req->query->get('catid'));
          // on supprime toute les astuce de ce chats
          // bon la bdd est en cascade et est cencé supprimer toute les astuces
          //elle meme si on supprime un chat
          foreach ($listtrick as $trick) {
            // on supprime les astuces
          $em->remove($trick);
          }
          //on supprime le chat
          $em->remove($cat);
          //on sauvegarde dans la bdd
          $em->flush();

        }
        //generation d'un formulaire avec une liste de chat
        //permet a l'user de selectionné un chat et d'etre envoyé sur la page
        // du chat correspondant
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('cat_name', 'entity', array(
          'class'    => 'appliwebBundle:Cat',
          'property' => 'French_name',
          'multiple' => false))
          ->add('send', 'submit')
          ->getForm();

          $form->handleRequest($req);
          //si le formulaire est valide on rentre dans la boucle
          if ($form->isValid()) {
            // on recupere les données du formulaire
            $data = $form->getData();
            //on renvoie vers la page du chat selectionné
            $content = new RedirectResponse('infocat?chat='.$data['cat_name']->getFrenchName());
          }else{
            //accé au repository chat
            /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('appliwebBundle:Cat')
            ;
            //on recupere tous les chats non publié
            $listCat = $repository->findByIsPublish(1);

            //  $listCat = $repository->findAll();
            //on renvoie les données necessaires a la vue
            $content = $this
            ->get('templating')
            ->render('appliwebBundle:Admin:catlist.html.twig', array(
              'listCat' => $listCat,
              'page' => 'cat-list',
              'form' => $form->createView()
              )
            );}
            return new Response($content);

          }
          // fonction d'affichage des astuces et chats non publié
          public function nopublishAction(Request $req)
          {

            //condition de suppression de chats
              if (null !== $req->query->get('catidrem'))
              {  //accé au repository cat
                $rep = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('appliwebBundle:Cat')
                ;
                //accé au repository trick
                $repos = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('appliwebBundle:Trick')
                ;
                //on recupere le manager
                $em = $this->getDoctrine()->getManager();

                //on recupere le chat a supprimer
                $cat = $rep->findOneById($req->query->get('catidrem'));
                //on recupere la liste d'astuce correspondant
                $listtrick = $repos->findByIdCat($req->query->get('catidrem'));
                //on supprime les astuces
                foreach ($listtrick as $trick) {
                  // $advert est une instance de Advert
                $em->remove($trick);
                }
                //on supprime les chats
                $em->remove($cat);
                //on flush tous dans la bdd
                $em->flush();

              }
              //ici on publie le chat correspondant a catid
              if (null !== $req->query->get('catid'))
              {
                // accé au repository cat
                $rep = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('appliwebBundle:Cat')
                ;
                //on recupere le manager
                $em = $this->getDoctrine()->getManager();
                //on recupere le chat
                $cat = $rep->findOneById($req->query->get('catid'));
                //on  set sont attribut publish a true
                $cat->setIsPublish(1);
                //on sauvegarde
                $em->flush();

              }
              //ici on publie une astuce
              if (null !== $req->query->get('trickid'))
              {  //accé au repository
                $rep = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('appliwebBundle:Trick')
                ;
                //on recupere le manager
                $em = $this->getDoctrine()->getManager();
                //on recupere l'astuce
                $trick = $rep->findOneById($req->query->get('trickid'));
                //on set son attribut publish a true
                $trick->setIsPublish(1);
                // on sauvegarde
                $em->flush();

              }
              //ici on supprime une astuce
              if (null !== $req->query->get('trickidrem'))
              {  //accé au repository trick
                $rep = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('appliwebBundle:Trick')
                ;
                //on recupere le manager
                $em = $this->getDoctrine()->getManager();
                // on recupere l'astuce
                $trick = $rep->findOneById($req->query->get('trickidrem'));
                //on supprime l'astuce
                $em->remove($trick);
                //on sauvegarde le tout
                $em->flush();

              }
              /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
              //accé au repository chat
              $repository = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('appliwebBundle:Cat')
              ;
              //on recupere la liste de toute les chat nom publié
              $listCat = $repository->findByIsPublish(0);
              //accé au repository chat
              $rep = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('appliwebBundle:Trick')
              ;
              //accé au repository user
              $repositoryss = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('OCUserBundle:User')
              ;
              //on reccupere toute les astuce non publié
              $listTrick = $rep->findByIsPublish(0);
              //on recupere tous les chats
              $listCat2 = $repository->findAll();
              //on recupere tous les user
              $listUser = $repositoryss->findAll();


              //  $listCat = $repository->findAll();
              //on renvoie les infos a la vue
              $content = $this
              ->get('templating')
              ->render('appliwebBundle:Admin:nopublish.html.twig', array(
                'listCat' => $listCat,
                'listTrick' => $listTrick,
                'listCat2' => $listCat2,
                'listUser' => $listUser,
                'page' => 'nopublish'
              )
            );
            return new Response($content);

          }

          public function trickAction(Request $req)
          {
            //ici on supprime une astuce
              if (null !== $req->query->get('trickid'))
              {  //accé au repository trick
                $rep = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('appliwebBundle:Trick')
                ;
                //on reccupere le manager
                $em = $this->getDoctrine()->getManager();
                //on recupere l'astuce
                $trick = $rep->findOneById($req->query->get('trickid'));
                //on la supprime
                $em->remove($trick);
                //on supprime
                $em->flush();

              }
              /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
              //accé au repository trick
              $repository = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('appliwebBundle:Trick')
              ;
              //accé au repository cat
              $repositorys = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('appliwebBundle:Cat')
              ;
              //accé au repository user
              $repositoryss = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('OCUserBundle:User')
              ;
              //on recupere les astuces publiées
              $listTrick = $repository->findByIsPublish(1);
              //on recupere tous les chats
              $listCat = $repositorys->findAll();
              //on recupere les users
              $listUser = $repositoryss->findAll();
              //on renvoie tous a la vue
              $content = $this
              ->get('templating')
              ->render('appliwebBundle:Admin:trick.html.twig', array(
                'listTrick' => $listTrick,
                'listCat' => $listCat,
                'listUser' => $listUser,
                'page' => 'trick'
              )
            );
            return new Response($content);

          }


                }?>

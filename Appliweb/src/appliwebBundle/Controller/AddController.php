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



class AddController extends Controller
{
  //fonction d'ajout d'astuce
  public function addtrickAction(Request $request)
  {

    //generation d'un formulaire contenant une list de nom de chat
    //et un champ de texte pour poster un commentaire
    //pas plus de 5000 caractere dans le champ de texte
    $defaultData = array('message' => 'Type your message here');
    $form = $this->createFormBuilder($defaultData)
    ->add('cat_name', 'entity', array(
      'class'    => 'appliwebBundle:Cat',
      'property' => 'French_name',
      'multiple' => false,'label' => 'Cat name : '))
      ->add('description', 'textarea',array('constraints' => new Length(array('min' => 10,'max' => 5000)),'label' => 'Trick description : '))
      ->add('send', 'submit')
      ->getForm();

      $form->handleRequest($request);


      //lorsque le formulaire est correctement remplis on rentre dans la condition
      if ($form->isValid()) {
        //on recupere les données du formulaire dans $data
        //elle sont sous forme de tableau ou chaque colone est le nom de l'attribut
        //correspondant dans le formulaire
        $data = $form->getData();
        //accés au repository cat
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Cat')
        ;
        //accés au repository cat
        $rep = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('OCUserBundle:User')
        ;
        //on recupere le chat correspondant au nom selectionné dans le formulaire
        $cat = $repository->findOneByFrench_name($data['cat_name']->getFrenchName());

        //si le chat n'existe pas genere une exeption
        //(ne sert plus depuis l'implementation de la liste)
        if (null === $cat) {
          throw new NotFoundHttpException("Le chat : ".$data['cat_name']->getFrenchName()." n'existe pas.");
        }
        //recuperation de l'utilisateur courant
        $user= $this->container->get('security.context')->getToken()->getUser();

        //verification si l'user est authentifié ou pas
        if (null === $user) {
          // Ici, l'utilisateur est anonyme ou l'URL n'est pas derrière un pare-feu
        } else {
          $userinbdd = $rep->findOneByUsername($user->getUsername());
          // Ici, $user est une instance de notre classe User
        }

        //creation d'un nouvel objet "Trick" grace au donnée du formulaire
        $trick=new Trick();
        $trick->setIdCat($cat->getId());
        $trick->setIdUser($userinbdd->getId());
        $trick->setTrickDescription($data['description']);
        $trick->setNbLike(0);
        $trick->setNbDislike(0);
        $trick->setIsPublish(0);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($trick);

        // Étape 2 : On « flush » tout ce qui a été persisté avant
        $em->flush();
        //on redirige vers notre page de redirection
        //return $this->redirect($this->generateUrl('index'));
        $content = new RedirectResponse('redir');

      }else{



        //on renvoie les données nécessaires à l'affichage
        $content = $this
        ->get('templating')
        ->render('appliwebBundle:Add:addtrick.html.twig', array(
          'form' => $form->createView(),
          'page' => 'addtrick'

        ));}
        return new Response($content);

      }
      //fonction d'ajout d'un chat
      public function addcatAction(Request $request)
      {

        //generation d'un formulaire demandant :
        //le nom de chat en anglais
        //le nom de chat en japonais
        //une Description du chat
        //une description de sa personnalité
        //un niveau
        //savoir s'il est rare ou pas
        //une image du chat
        //une image du memento
        //attention seul les formats png sont accepté
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('french_name', 'text', array('constraints' => new Length(array('min' => 3,'max' => 20)),'label' => 'Name : '))
        ->add('japanese_name', 'text',array('constraints' => new Length(array('min' => 3,'max' => 45)),'label' => 'Japanese name : '))
        ->add('description', 'textarea',array('constraints' => new Length(array('min' => 3,'max' => 30)),'label' => 'Description : '))
        ->add('personality', 'text',array('constraints' => new Length(array('min' => 3,'max' => 20)),'label' => 'Personality : '))
        ->add('level', 'integer',array('constraints' => new Range(array('min' => 1,'max' => 999)),'label' => 'Level : '))
        ->add('israre', 'checkbox',array('required' => false,'label' => 'Rare cat ? : '))
        ->add('image', 'file',array('constraints' => new File(array('mimeTypes' => 'image/png')),'label' => 'Cat image : '))
        ->add('memento', 'file',array('constraints' => new File(array('mimeTypes' => 'image/png')),'label' => 'Memento image : '))
        ->add('send', 'submit')
        ->getForm();

        $form->handleRequest($request);

        //variable de test d'existance du nom du chat
          $error="non";
        //lorsque le formulaire est correctement remplis on rentre dans la condition
        if ($form->isValid()) {
          //on recupere les données du formulaire dans $data
          //elle sont sous forme de tableau ou chaque colone est le nom de l'attribut
          //correspondant dans le formulaire
          $data = $form->getData();
          //accés au repository cat
          $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('appliwebBundle:Cat')
          ;
          //recupere une liste de chat qui posséde le meme nom que celui entré dans le formulaire
          $cattest = $repository->findOneByFrench_name($data['french_name']);
          //Si la liste est non null, on gérére une erreur

          if ($cattest != null) {
          $error="oui";
          }
          //recupere une liste de chat qui posséde le meme nom que celui entré dans le formulaire
          $cattest = $repository->findOneByJapanese_name($data['japanese_name']);
          //Si la liste est non null, on gérére une erreur
          if ($cattest != null) {
            $error="oui";
          }
          if($error === "non"){
          //creation d'un chat avec les données d'un formulaire
          $cat=new Cat();
          $cat->setFrenchName($data['french_name']);
          $cat->setJapaneseName($data['japanese_name']);
          $cat->setDescription($data['description']);
          $cat->setPersonality($data['personality']);
          $cat->setLevel($data['level']);
          $cat->setIsRare($data['israre']);
          $cat->setIsPublish(0);
          //ajout d'images1 dans le dossier assets
          $image1=new Image();
          $image1->setFile($data['image']);
          $image1->upload("Assets/Image",$data['french_name'].".png");
          //ajout d'images2 dans le dossier assets
          $image2=new Image();
          $image2->setFile($data['memento']);
          $image2->upload("Assets/Image/Memento",$data['french_name'].".png");


          // On récupère l'EntityManager
          $em = $this->getDoctrine()->getManager();

          // Étape 1 : On « persiste » l'entité
          $em->persist($cat);

          // Étape 2 : On « flush » tout ce qui a été persisté avant
          $em->flush();
          //on redirige sur notre page de redirection
          //return $this->redirect($this->generateUrl('index'));
          //si pas d'erreur on redirige

            $content = new RedirectResponse('redir');
          }else{
            //sinon on relance la vue
            $content = $this
            ->get('templating')
            ->render('appliwebBundle:Add:addcat.html.twig', array(
              'form' => $form->createView(),
              'error' => $error,
              'page' => 'addcat'
            ));
          }
        }else{

        //retourne les infos necessaire pour la vue
          $content = $this
          ->get('templating')
          ->render('appliwebBundle:Add:addcat.html.twig', array(
            'form' => $form->createView(),
            'error' =>$error,
            'page' => 'addcat'
          ));}
          return new Response($content);

        }






      }?>

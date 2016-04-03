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



class EditController extends Controller
{
//edition d'un chat
  public function edittrickAction(Request $request)
  {
      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();
      //on recupere l'id de l'astuce
      $idtrick = $request->query->get('trick');
      //on recupere la description
      $desctrick = $request->query->get('desc');
      //accé au repository Trick
      $repositor = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('appliwebBundle:Trick')
      ;
      //on recupere l'astuce actuelle
      $trickactuel = $repositor->findOneById($idtrick);

      //on cree un formulaire avec un champ de text pour taper l'astuce
      // 5000 char max !
      $defaultData = array('message' => 'Type your message here');
      $form = $this->createFormBuilder($defaultData)
      ->add('description', 'textarea',array('constraints' => new Length(array('min' => 10,'max' => 5000)),'label' => 'Trick description : ','data' => $trickactuel->getTrickDescription()))
      ->add('send', 'submit')
      ->getForm();



      $form->handleRequest($request);
      //si le formulaire est valide
      if ($form->isValid()) {
        // on recupere les valeurs entrées dans le formulaire
        $data = $form->getData();

        //on recupere la description du formulaire et on la set dans
        //notre objet
        $trickactuel->setTrickDescription($data['description']);
        //on save tout dans la bdd
        $em->flush();
        //on redirige sur la page redirection
        //return $this->redirect($this->generateUrl('index'));
        $content = new RedirectResponse('redir');

      }else{

        //on envoie les donnes necessaire a la vue

        $content = $this
        ->get('templating')
        ->render('appliwebBundle:Edit:edittrick.html.twig', array(
          'form' => $form->createView(),
          'id' => $idtrick,
          'desc' => $desctrick,
          'page' => 'trick'
        ));}
        return new Response($content);
      }
      //fonction d'edition d'un chat
      public function editcatAction(Request $request)
      {
          //On recupere l'id du chat a modifié
          $id = $request->query->get('catid');
          //accé au repository cat
          $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('appliwebBundle:Cat')
          ;
          //on recupere la description du chat actuel
          $catactuel = $repository->findOneById($id);
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
          ->add('french_name', 'text', array('constraints' => new Length(array('min' => 3,'max' => 20)),'label' => 'Name : ','data' => $catactuel->getFrenchName() ))
          ->add('japanese_name', 'text',array('constraints' => new Length(array('min' => 3,'max' => 45)),'label' => 'Japanese name : ','data' => $catactuel->getJapaneseName()))
          ->add('description', 'textarea',array('constraints' => new Length(array('min' => 3,'max' => 30)),'label' => 'Description : ','data' => $catactuel->getDescription()))
          ->add('personality', 'text',array('constraints' => new Length(array('min' => 3,'max' => 20)),'label' => 'Personality : ','data' => $catactuel->getPersonality()))
          ->add('level', 'integer',array('constraints' => new Range(array('min' => 1,'max' => 999)),'label' => 'Level : ','data' => $catactuel->getLevel()))
          ->add('israre', 'checkbox',array('required' => false,'label' => 'Rare cat ? : ', 'data' => $catactuel->getIsRare()))
          ->add('image', 'file',array('constraints' => new File(array('mimeTypes' => 'image/png')),'required' => false,'label' => 'Cat image (not mandatory) : '))
          ->add('memento', 'file',array('constraints' => new File(array('mimeTypes' => 'image/png')),'required' => false,'label' => 'Memento image (not mandatory) : '))
          ->add('send', 'submit')
          ->getForm();

          $form->handleRequest($request);
          //si le formulaire est valide
          if ($form->isValid()) {
            // on recupere toute les valeur du form
            $data = $form->getData();
            //on recupere le manager
            $em = $this->getDoctrine()->getManager();

            //si le chat existe pas on genere une erreur
            if (null === $catactuel) {
              throw new NotFoundHttpException("Le chat : ".$data['french_name']." n'existe pas.");
            }
            //on modifie le chat actuel avec les donnée du commantaire
            $catactuel->setFrenchName($data['french_name']);
            $catactuel->setJapaneseName($data['japanese_name']);
            $catactuel->setDescription($data['description']);
            $catactuel->setPersonality($data['personality']);
            $catactuel->setLevel($data['level']);
            $catactuel->setIsRare($data['israre']);
            //si l'image n'est pas null on la sauvegarde dans le bon dossier
            if($data['image'] != null){

            $image1=new Image();
            $image1->setFile($data['image']);
            $image1->upload("Assets/Image",$data['french_name'].".png");
          }
            //si l'image n'est pas null on la sauvegarde dans le bon dossier
            if($data['memento'] != null){

            $image2=new Image();
            $image2->setFile($data['memento']);
            $image2->upload("Assets/Image/Memento",$data['french_name'].".png");
            }
            // on sauvegarde tous dans la base de donnée
            $em->flush();
            //on redirige vers notre page de redirection
            $content = new RedirectResponse('redir');
          }else {

            //on renvoie les données necessaire a la vue 
            $content = $this
            ->get('templating')
            ->render('appliwebBundle:Edit:editcat.html.twig', array(
              'page' => 'cat-list',
              'form' => $form->createView()
            ));}
            return new Response($content);

          }


  }?>

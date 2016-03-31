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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class AdvertController extends Controller
{
  public function indexAction(Request $request)
  {
    $content = $this
    ->get('templating')
    ->render('appliwebBundle:Advert:index.html.twig', array(
      'page' => 'index'
    ));
    return new Response($content);

  }



  public function catlistAction(Request $req)
  {



    $defaultData = array('message' => 'Type your message here');
    $form = $this->createFormBuilder($defaultData)
    ->add('cat_name', 'entity', array(
      'class'    => 'appliwebBundle:Cat',
      'property' => 'French_name',
      'multiple' => false))
      ->add('send', 'submit')
      ->getForm();

      $form->handleRequest($req);

      if ($form->isValid()) {
        // data is an array with "name", "email", and "message" keys
        $data = $form->getData();
        $content = new RedirectResponse('infocat?chat='.$data['cat_name']->getFrenchName());
      }else{
        /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Cat')
        ;

        $listCat = $repository->findByIsPublish(1);

        //  $listCat = $repository->findAll();

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




      public function infocatAction(Request $req)
      {


        $tag = $req->query->get('chat');

        /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Cat')
        ;
        $rep = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Trick')
        ;
        $repp = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('OCUserBundle:User')
        ;
        $user=  $repp->findAll();
        $cat = $repository->findOneByFrench_name($tag);
        $trick = $rep->findByIdCat($cat->getId());


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


    public function foodAction()
    {



      /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('appliwebBundle:Food')
      ;

      $listFood = $repository->findAll();
      //$food = $repository->findByName('Sashimi');

      $content = $this
      ->get('templating')
      ->render('appliwebBundle:Advert:food.html.twig', array(
        'listFood' => $listFood,
        'page' => 'food'
      )
    );
    return new Response($content);

  }

  public function goodiesAction()
  {


    /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
    $repository = $this
    ->getDoctrine()
    ->getManager()
    ->getRepository('appliwebBundle:Goodies')
    ;

    $listGoodies = $repository->findAll();
    $content = $this
    ->get('templating')
    ->render('appliwebBundle:Advert:goodies.html.twig', array(
      'listGoodies' => $listGoodies,
      'page' => 'goodies'
    )
  );
  return new Response($content);

}

public function addtrickAction(Request $request)
{


  $defaultData = array('message' => 'Type your message here');
  $form = $this->createFormBuilder($defaultData)
  ->add('cat_name', 'entity', array(
    'class'    => 'appliwebBundle:Cat',
    'property' => 'French_name',
    'multiple' => false))
    ->add('description', 'textarea')
    ->add('send', 'submit')
    ->getForm();

    $form->handleRequest($request);



    if ($form->isValid()) {
      // data is an array with "name", "email", and "message" keys
      $data = $form->getData();

      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('appliwebBundle:Cat')
      ;

      $rep = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('OCUserBundle:User')
      ;

      $cat = $repository->findOneByFrench_name($data['cat_name']->getFrenchName());
      if (null === $cat) {
        throw new NotFoundHttpException("Le chat : ".$data['cat_name']->getFrenchName()." n'existe pas.");
      }


      // On récupère le service

      $user= $this->container->get('security.context')->getToken()->getUser();


      if (null === $user) {
        // Ici, l'utilisateur est anonyme ou l'URL n'est pas derrière un pare-feu
      } else {
        $userinbdd = $rep->findOneByUsername($user->getUsername());
        // Ici, $user est une instance de notre classe User
      }


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

      //return $this->redirect($this->generateUrl('index'));
      $content = new RedirectResponse('index');

    }else{

      //fonctionne !


      $content = $this
      ->get('templating')
      ->render('appliwebBundle:Advert:addtrick.html.twig', array(
        'form' => $form->createView(),
        'page' => 'addtrick'

      ));}
      return new Response($content);

    }

    public function addcatAction(Request $request)
    {


      $defaultData = array('message' => 'Type your message here');
      $form = $this->createFormBuilder($defaultData)
      ->add('french_name', 'text', array('constraints' => new Length(array('min' => 3))))
      ->add('japanese_name', 'text')
      ->add('description', 'textarea')
      ->add('personality', 'text')
      ->add('level', 'integer')
      ->add('israre', 'checkbox',array('required' => false))
      ->add('image', 'file')
      ->add('memento', 'file')
      ->add('send', 'submit')
      ->getForm();

      $form->handleRequest($request);



      if ($form->isValid()) {
        // data is an array with "name", "email", and "message" keys
        $data = $form->getData();

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Cat')
        ;

        $cattest = $repository->findOneByFrench_name($data['french_name']);
        if ($cattest != null) {
          throw new UnsupportedMediaTypeHttpException("Le nom est déjà utilisé : ".$data['french_name']->getClientOriginalName());
        }
        $cattest = $repository->findOneByJapanese_name($data['japanese_name']);
        if ($cattest != null) {
          throw new UnsupportedMediaTypeHttpException("Le nom est déjà utilisé : ".$data['japanese_name']->getClientOriginalName());
        }
        $cat=new Cat();
        $cat->setFrenchName($data['french_name']);
        $cat->setJapaneseName($data['japanese_name']);
        $cat->setDescription($data['description']);
        $cat->setPersonality($data['personality']);
        $cat->setLevel($data['level']);
        $cat->setIsRare($data['israre']);
        $cat->setIsPublish(0);


        $pos = strpos($data['image']->getClientOriginalName(), ".png");
        if($pos === false){

          throw new UnsupportedMediaTypeHttpException("Le format de l'image n'est pas respecté (png seulement !) : ".$data['image']->getClientOriginalName());
        }

        $poss = strpos($data['memento']->getClientOriginalName(), ".png");
        if($poss === false){

          throw new UnsupportedMediaTypeHttpException("Le format de l'image n'est pas respecté (png seulement !) : ".$data['image']->getClientOriginalName());
        }

        $image1=new Image();
        $image1->setFile($data['image']);
        $image1->upload("Assets/Image",$data['french_name'].".png");

        $image2=new Image();
        $image2->setFile($data['memento']);
        $image2->upload("Assets/Image/Memento",$data['french_name'].".png");


        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($cat);

        // Étape 2 : On « flush » tout ce qui a été persisté avant
        $em->flush();

        //return $this->redirect($this->generateUrl('index'));
        $content = new RedirectResponse('index');
      }else{

        //fonctionne !


        $content = $this
        ->get('templating')
        ->render('appliwebBundle:Advert:addcat.html.twig', array(
          'form' => $form->createView(),
          'page' => 'addcat'
        ));}
        return new Response($content);

      }


      public function trickAction(Request $req)
      {


        if (null !== $req->query->get('votegid'))
        {  $rep = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('appliwebBundle:Trick')
          ;
          $em = $this->getDoctrine()->getManager();

          $trick = $rep->findOneById($req->query->get('votegid'));
          $nblike= $trick->getNbLike();

          $trick->setNbLike($nblike+1);
          $em->persist($trick);
          $em->flush();

        }
        if (null !== $req->query->get('votebid'))
        {  $rep = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('appliwebBundle:Trick')
          ;
          $em = $this->getDoctrine()->getManager();

          $trick = $rep->findOneById($req->query->get('votebid'));
          $nblike= $trick->getNbDislike();

          $trick->setNbDislike($nblike+1);
          $em->persist($trick);
          $em->flush();

        }
        /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Trick')
        ;
        $repositorys = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:Cat')
        ;
        $repositoryss = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('OCUserBundle:User')
        ;

        $listTrick = $repository->findByIsPublish(1);
        $listCat = $repositorys->findAll();
        $listUser = $repositoryss->findAll();

        $content = $this
        ->get('templating')
        ->render('appliwebBundle:Advert:trick.html.twig', array(
          'listTrick' => $listTrick,
          'listCat' => $listCat,
          'listUser' => $listUser,
          'page' => 'trick'
        )
      );
      return new Response($content);

    }




  }?>

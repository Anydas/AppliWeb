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

    public function userAction(Request $req)
    {
      if (null !== $req->query->get('userid'))
       {  $rep = $this
           ->getDoctrine()
           ->getManager()
           ->getRepository('appliwebBundle:user')
         ;
         $em = $this->getDoctrine()->getManager();

         $cat = $rep->findOneById($req->query->get('userid'));

        $cat->setIsBan(1);

         $em->flush();

       }

       if (null !== $req->query->get('useriddeb'))
        {  $rep = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('appliwebBundle:user')
          ;
          $em = $this->getDoctrine()->getManager();

          $cat = $rep->findOneById($req->query->get('useriddeb'));

         $cat->setIsBan(0);

          $em->flush();

        }
      $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('appliwebBundle:user')
      ;

      $listuser = $repository->findAll();

    $content = $this
    ->get('templating')
    ->render('appliwebBundle:Advert:user.html.twig', array(
        'page' => 'user',
        'listUser' => $listuser
    ));
    return new Response($content);

    }

	 public function catlistAction(Request $req)
    {


      if (null !== $req->query->get('catid'))
      {  $rep = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('appliwebBundle:Cat')
        ;
        $em = $this->getDoctrine()->getManager();

        $cat = $rep->findOneById($req->query->get('catid'));

        $em->remove($cat);

        $em->flush();

      }
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

    public function nopublishAction(Request $req)
     {
       if (null !== $req->query->get('catidrem'))
       {  $rep = $this
           ->getDoctrine()
           ->getManager()
           ->getRepository('appliwebBundle:Cat')
         ;
         $em = $this->getDoctrine()->getManager();

         $cat = $rep->findOneById($req->query->get('catidrem'));

         $em->remove($cat);

         $em->flush();

       }

       if (null !== $req->query->get('catid'))
       {  $rep = $this
           ->getDoctrine()
           ->getManager()
           ->getRepository('appliwebBundle:Cat')
         ;
         $em = $this->getDoctrine()->getManager();

         $cat = $rep->findOneById($req->query->get('catid'));

        $cat->setIsPublish(1);

         $em->flush();

       }
       if (null !== $req->query->get('trickid'))
       {  $rep = $this
           ->getDoctrine()
           ->getManager()
           ->getRepository('appliwebBundle:Trick')
         ;
         $em = $this->getDoctrine()->getManager();

         $trick = $rep->findOneById($req->query->get('trickid'));

         $trick->setIsPublish(1);

         $em->flush();

       }

       if (null !== $req->query->get('trickidrem'))
       {  $rep = $this
           ->getDoctrine()
           ->getManager()
           ->getRepository('appliwebBundle:Trick')
         ;
         $em = $this->getDoctrine()->getManager();

         $trick = $rep->findOneById($req->query->get('trickidrem'));

          $em->remove($trick);

         $em->flush();

       }
       /*$content = $this->get('templating')->render('appliwebBundle:Advert:fin.html.twig');*/
       $repository = $this
         ->getDoctrine()
         ->getManager()
         ->getRepository('appliwebBundle:Cat')
       ;

       $listCat = $repository->findByIsPublish(0);

       $rep = $this
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
         ->getRepository('appliwebBundle:user')
       ;

     $listTrick = $rep->findByIsPublish(0);
    $listCat2 = $repositorys->findAll();
    $listUser = $repositoryss->findAll();


   //  $listCat = $repository->findAll();

 $content = $this
     ->get('templating')
     ->render('appliwebBundle:Advert:nopublish.html.twig', array(
         'listCat' => $listCat,
         'listTrick' => $listTrick,
         'listCat2' => $listCat2,
         'listUser' => $listUser,
         'page' => 'nopublish'
     )
 );
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

      $cat = $repository->findByFrench_name($tag);

       $content = $this
     ->get('templating')
     ->render('appliwebBundle:Advert:infocat.html.twig', array(
         'nom' => $cat,
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

         $cat = $repository->findOneByFrench_name($data['cat_name']->getFrenchName());
         if (null === $cat) {
      throw new NotFoundHttpException("Le chat : ".$data['cat_name']->getFrenchName()." n'existe pas.");
    }

          $trick=new Trick();
          $trick->setIdCat($cat->getId());
          $trick->setIdUser(1);
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

       if (null !== $req->query->get('trickid'))
       {  $rep = $this
           ->getDoctrine()
           ->getManager()
           ->getRepository('appliwebBundle:Trick')
         ;
         $em = $this->getDoctrine()->getManager();

         $trick = $rep->findOneById($req->query->get('trickid'));

         $em->remove($trick);

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
         ->getRepository('appliwebBundle:user')
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

     public function edittrickAction(Request $request)
         {
             // On récupère l'EntityManager
             $em = $this->getDoctrine()->getManager();

             $idtrick = $request->query->get('trick');
             $desctrick = $request->query->get('desc');

             $defaultData = array('message' => 'Type your message here');
             $form = $this->createFormBuilder($defaultData)
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
                 ->getRepository('appliwebBundle:Trick')
               ;


             $trickactuel = $repository->findOneById($idtrick);
             $trickactuel->setTrickDescription($data['description']);

             $em->flush();

             //return $this->redirect($this->generateUrl('index'));
             $content = new RedirectResponse('index');

             }else{

               //fonctionne !

             $content = $this
                 ->get('templating')
                 ->render('appliwebBundle:Advert:edittrick.html.twig', array(
                     'form' => $form->createView(),
                     'id' => $idtrick,
                     'desc' => $desctrick,
                     'page' => 'trick'
                   ));}
                 return new Response($content);
         }

         public function editcatAction(Request $request)
         {
           $id = $request->query->get('catid');
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

            $em = $this->getDoctrine()->getManager();

            $repository = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('appliwebBundle:Cat')
            ;

            $catactuel = $repository->findOneById($id);
            if (null === $catactuel) {
         throw new NotFoundHttpException("Le chat : ".$data['french_name']." n'existe pas.");
       }

            $catactuel->setFrenchName($data['french_name']);
            $catactuel->setJapaneseName($data['japanese_name']);
            $catactuel->setDescription($data['description']);
            $catactuel->setPersonality($data['personality']);
            $catactuel->setLevel($data['level']);
            $catactuel->setIsRare($data['israre']);


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

            $em->flush();
            $content = new RedirectResponse('index');
          }else {


           $content = $this
           ->get('templating')
           ->render('appliwebBundle:Advert:editcat.html.twig', array(
             'page' => 'cat-list',
             'form' => $form->createView()
           ));}
         return new Response($content);

         }
}?>

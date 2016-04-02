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

  public function userAction(Request $req)
  {



      if (null !== $req->query->get('userid'))
      {  $rep = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('OCUserBundle:User')
        ;
        $em = $this->getDoctrine()->getManager();

        $cat = $rep->findOneById($req->query->get('userid'));

        $cat->setLocked(1);

        $em->flush();

      }

      if (null !== $req->query->get('useriddeb'))
      {  $rep = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('OCUserBundle:User')
        ;
        $em = $this->getDoctrine()->getManager();

        $cat = $rep->findOneById($req->query->get('useriddeb'));

        $cat->setLocked(0);

        $em->flush();

      }
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('OCUserBundle:User')
      ;

      $listuser = $repository->findAll();

      $content = $this
      ->get('templating')
      ->render('appliwebBundle:Admin:user.html.twig', array(
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
          $repos = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('appliwebBundle:Trick')
          ;
          $em = $this->getDoctrine()->getManager();

          $cat = $rep->findOneById($req->query->get('catid'));
          $listtrick = $repos->findByIdCat($req->query->get('catid'));

          foreach ($listtrick as $trick) {
            // $advert est une instance de Advert
          $em->remove($trick);
          }
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
            ->render('appliwebBundle:Admin:catlist.html.twig', array(
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

                $repos = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('appliwebBundle:Trick')
                ;

                $em = $this->getDoctrine()->getManager();

                $cat = $rep->findOneById($req->query->get('catidrem'));
                $listtrick = $repos->findByIdCat($req->query->get('catidrem'));

                foreach ($listtrick as $trick) {
                  // $advert est une instance de Advert
                $em->remove($trick);
                }

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
              ->getRepository('OCUserBundle:User')
              ;

              $listTrick = $rep->findByIsPublish(0);
              $listCat2 = $repositorys->findAll();
              $listUser = $repositoryss->findAll();


              //  $listCat = $repository->findAll();

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
              ->getRepository('OCUserBundle:User')
              ;

              $listTrick = $repository->findByIsPublish(1);
              $listCat = $repositorys->findAll();
              $listUser = $repositoryss->findAll();

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

          public function edittrickAction(Request $request)
          {
              // On récupère l'EntityManager
              $em = $this->getDoctrine()->getManager();

              $idtrick = $request->query->get('trick');
              $desctrick = $request->query->get('desc');

              $repositor = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('appliwebBundle:Trick')
              ;

              $trickactuel = $repositor->findOneById($idtrick);


              $defaultData = array('message' => 'Type your message here');
              $form = $this->createFormBuilder($defaultData)
              ->add('description', 'textarea',array('constraints' => new Length(array('min' => 10,'max' => 5000)),'label' => 'Trick description : ','data' => $trickactuel->getTrickDescription()))
              ->add('send', 'submit')
              ->getForm();



              $form->handleRequest($request);

              if ($form->isValid()) {
                // data is an array with "name", "email", and "message" keys
                $data = $form->getData();


                $trickactuel->setTrickDescription($data['description']);

                $em->flush();

                //return $this->redirect($this->generateUrl('index'));
                $content = new RedirectResponse('redir');

              }else{

                //fonctionne !

                $content = $this
                ->get('templating')
                ->render('appliwebBundle:Admin:edittrick.html.twig', array(
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
                  $repository = $this
                  ->getDoctrine()
                  ->getManager()
                  ->getRepository('appliwebBundle:Cat')
                  ;

                  $catactuel = $repository->findOneById($id);

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

                  if ($form->isValid()) {
                    // data is an array with "name", "email", and "message" keys
                    $data = $form->getData();

                    $em = $this->getDoctrine()->getManager();


                    if (null === $catactuel) {
                      throw new NotFoundHttpException("Le chat : ".$data['french_name']." n'existe pas.");
                    }

                    $catactuel->setFrenchName($data['french_name']);
                    $catactuel->setJapaneseName($data['japanese_name']);
                    $catactuel->setDescription($data['description']);
                    $catactuel->setPersonality($data['personality']);
                    $catactuel->setLevel($data['level']);
                    $catactuel->setIsRare($data['israre']);

                    if($data['image'] != null){

                    $image1=new Image();
                    $image1->setFile($data['image']);
                    $image1->upload("Assets/Image",$data['french_name'].".png");
                  }

                    if($data['memento'] != null){

                    $image2=new Image();
                    $image2->setFile($data['memento']);
                    $image2->upload("Assets/Image/Memento",$data['french_name'].".png");
                    }

                    $em->flush();
                    $content = new RedirectResponse('redir');
                  }else {


                    $content = $this
                    ->get('templating')
                    ->render('appliwebBundle:Admin:editcat.html.twig', array(
                      'page' => 'cat-list',
                      'form' => $form->createView()
                    ));}
                    return new Response($content);

                  }
                }?>

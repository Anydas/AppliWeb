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



class RedirectionController extends Controller
{
  public function redirAction(Request $request)
  {
    $content = $this
    ->get('templating')
    ->render('appliwebBundle:Redirection:redir.html.twig', array(
      'page' => 'index'
    ));
    return new Response($content);

  }






  }?>

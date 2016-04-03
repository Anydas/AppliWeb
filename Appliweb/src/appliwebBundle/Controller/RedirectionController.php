<?php

// src/appliwebBundle/Controller/AdvertController.php

namespace appliwebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class RedirectionController extends Controller
{
  //fonction pour rediriger les utilisateurs
  public function redirAction(Request $request)
  { //aucun traitenment necessaire dans le controleur, on passe directement
    //a la vue
    $content = $this
    ->get('templating')
    ->render('appliwebBundle:Redirection:redir.html.twig', array(
      'page' => 'index'
    ));
    return new Response($content);

  }

  }?>

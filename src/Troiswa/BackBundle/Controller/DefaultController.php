<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
#use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TroiswaBackBundle:Default:index.html.twig', array('name' => $name));
    }
    public function tryAction()
    {
        #return new Response("message");
        return $this->render("TroiswaBackBundle:Default:mapage.html.twig", ["prenom"=>"Julian"]); #bundle:nom du dossier dans views:nom de la page dans views
    }
}

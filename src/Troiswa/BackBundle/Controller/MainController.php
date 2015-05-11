<?php

namespace Troiswa\BackBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function adminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $nbFilms=$em->getRepository("TroiswaBackBundle:Films")->getNombreDeFilm();
        $nbActeurs=$em->getRepository("TroiswaBackBundle:Acteurs")->getNombreActeur();       
        $bestFilm=$em->getRepository("TroiswaBackBundle:Films")->getBestFilm();
        $nbGenre=$em->getRepository("TroiswaBackBundle:Acteurs")->getNbGenreActeur();
        $lastFilm=$em->getRepository("TroiswaBackBundle:Films")->getLastFilm(5);
        $filmByGenre=$em->getRepository("TroiswaBackBundle:Films")->getFilmByGenre("comédie");
        return $this->render("TroiswaBackBundle:Main:dashboard.html.twig", ["nbFilms"=>$nbFilms, "nbActeurs"=>$nbActeurs,"bestFilm"=>$bestFilm, "nbGenre"=>$nbGenre, "lastFilm"=>$lastFilm, "filmByGenre"=>$filmByGenre ]);
    }
}






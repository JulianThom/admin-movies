<?php

namespace Troiswa\BackBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\Genre;

class GenresController extends Controller
{
    public function listingGenresAction()
    {
        $em=$this->getDoctrine()->getManager();
        //$em équivaut au $connexion em=entity manager
        $tousLesGenres=$em->getRepository("TroiswaBackBundle:Genre")->findAll();
        return $this->render("TroiswaBackBundle:Genres:listeGenres.html.twig", ["genres"=>$tousLesGenres]);
    }
    public function createGenreAction(Request $request)
    {
        $nouveauGenre= new Genre();
        $form=$this->createFormBuilder($nouveauGenre)
                   ->add("type", "text")
                   ->add("description", "textarea")
                   ->add("ajouter", "submit")
                   ->getForm();
        if ($request->isMethod("POST"))
        {
            $form->submit($request);
            if ($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();
                $em->persist($nouveauGenre);
                $em->flush();
                $showMessageFlash=$request->getSession();
                $showMessageFlash->getFlashBag()->add("success_genre", "Votre genre a bien été ajouté.");
                return $this->redirect($this->generateUrl("troiswa_back_listingGenres"));
            }
        }
        return $this->render("TroiswaBackBundle:Genres:createGenre.html.twig", ["formGenre"=>$form->createView()]);
    }
    public function modifGenreAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $genre=$em->getRepository("TroiswaBackBundle:Genre")->find($id);

        $form=$this->createFormBuilder($genre)
            ->add("type", "text")
            ->add("description", "textarea")
            ->add("modifier", "submit")
            ->getForm();
        if ($request->isMethod("POST"))
        {
            $form->submit($request);
            if ($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();
                $em->persist($genre);
                $em->flush();
                $showMessageFlash=$request->getSession();
                $showMessageFlash->getFlashBag()->add("success_genre", "Votre genre a bien été modifié.");
                return $this->redirect($this->generateUrl("troiswa_back_listingGenres"));
            }
        }
        return $this->render("TroiswaBackBundle:Genres:modifGenre.html.twig", ["formGenre"=>$form->createView()]);
    }
    public function suppGenreAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $genre=$em->getRepository("TroiswaBackBundle:Genre")->find($id);
        $em->remove($genre);
        $em->flush();
        $showMessageFlash=$request->getSession();
        $showMessageFlash->getFlashBag()->add("success_genre", "Votre genre a bien été supprimé.");
        return $this->redirect($this->generateUrl("troiswa_back_listingGenres"));
    }
}

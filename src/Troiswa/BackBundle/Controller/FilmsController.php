<?php

namespace Troiswa\BackBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Troiswa\BackBundle\Entity\Films;

class FilmsController extends Controller
{
    public function listingFilmsAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        //$em équivaut au $connexion em=entity manager
        $dql   = "SELECT a FROM TroiswaBackBundle:Films a
                ORDER BY a.dateReal desc";
        $tousLesFilms = $em->createQuery($dql);
        //Pagination (utilisable grâce au bundle téléchargé sur github
        $paginator  = $this->get('knp_paginator');
        $paginationFilms = $paginator->paginate(
            $tousLesFilms,
            $request->query->get('page', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render("TroiswaBackBundle:Films:listeFilms.html.twig", ["films"=>$paginationFilms]);
    }
    public function getFicheFilmByIDAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $unFilm=$em->getRepository("TroiswaBackBundle:Films")->find($id);
        return $this->render("TroiswaBackBundle:Films:ficheFilm.html.twig", ["unFilm"=>$unFilm]);
    }

    public function createFilmAction(Request $request)
    {
        $nouveauFilm= new Films();
        $nouveauFilm->setDateAjout(new \DateTime('now'));
        $form=$this->createFormBuilder($nouveauFilm)
            ->add("titre", "text")
            ->add("description", "text")
            ->add("liaisonGenre", "entity",
            [
                "class"=>"TroiswaBackBundle:Genre",
                "property"=>"type",
            ])
            ->add("dateReal", "date",
                array(
                    'years' => range(date('Y')-100,date('Y')),
                    'format' => 'dd-MM-yyyy',
                ))
            ->add("note", "text")            
            ->add("fichier", "file", [
                'constraints' => new NotBlank(['message' => "Vous devez choisir une image."])
            ])
            ->add("ajouter", "submit")
            ->getForm();
        if ($request->isMethod("POST"))
        {
            $form->submit($request);
            if ($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();
                $nouveauFilm->upload();
                $em->persist($nouveauFilm);
                $em->flush();
                $showMessageFlash=$request->getSession();
                $showMessageFlash->getFlashBag()->add("success_film", "Votre film a bien été ajouté.");
                return $this->redirect($this->generateUrl("troiswa_back_listingFilms"));
            }
        }
        return $this->render("TroiswaBackBundle:Films:createFilm.html.twig", ["formFilm"=>$form->createView()]);
    }

    public function modifFilmAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $film=$em->getRepository("TroiswaBackBundle:Films")->find($id);

        $form=$this->createFormBuilder($film)
           ->add("titre", "text")
            ->add("description", "text")
            ->add("liaisonGenre", "entity",
            [
                "class"=>"TroiswaBackBundle:Genre",
                "property"=>"type",
            ])
            ->add("dateReal", "date",
                array(
                    'years' => range(date('Y')-100,date('Y')),
                    'format' => 'dd-MM-yyyy',
                ))
                ->add('dateAjout', "date",
                array(
                    'data' => new \DateTime("now"),
                    'format' => 'y-M-d H:i:s',
                ))
            ->add("note", "text")
            ->add("fichier", "file", [
                'constraints' => new NotBlank(['message' => "Vous devez choisir une image."])
            ])
            ->add("modifier", "submit")
            ->getForm();

        if ($request->isMethod("POST"))
        {
            $form->submit($request);
            if ($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();
                $film->upload();
                $em->persist($film);
                $em->flush();
                $showMessageFlash=$request->getSession();
                $showMessageFlash->getFlashBag()->add("success_film", "Votre film a bien été modifié.");
                return $this->redirect($this->generateUrl("troiswa_back_listingFilms"));
            }
        }
        return $this->render("TroiswaBackBundle:Films:modifFilm.html.twig", ["formFilm"=>$form->createView()]);
    }

    public function suppFilmAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $film=$em->getRepository("TroiswaBackBundle:Films")->find($id);
        $em->remove($film);
        $em->flush();
        $showMessageFlash=$request->getSession();
        $showMessageFlash->getFlashBag()->add("success_film", "Votre film a bien été supprimé.");
        return $this->redirect($this->generateUrl("troiswa_back_listingFilms"));
    }
}
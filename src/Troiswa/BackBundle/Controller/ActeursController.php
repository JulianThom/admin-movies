<?php

namespace Troiswa\BackBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Troiswa\BackBundle\Entity\Acteurs;

class ActeursController extends Controller
{
    public function listingActeursAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        //$em équivaut au $connexion em=entity manager
        $dql   = "SELECT a FROM TroiswaBackBundle:Acteurs a
                ORDER BY a.dateAjout desc";
        $tousLesActeurs = $em->createQuery($dql);
        //Pagination (utilisable grâce au bundle téléchargé sur github
        $paginator  = $this->get('knp_paginator');
        $paginationActeurs = $paginator->paginate(
            $tousLesActeurs,
            $request->query->get('page', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render("TroiswaBackBundle:Acteurs:listeActeurs.html.twig", ["acteurs"=>$paginationActeurs]);
    }

    public function listingHommesAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        //$em équivaut au $connexion em=entity manager
        $tousLesHommes=$em->getRepository("TroiswaBackBundle:Acteurs")->getAllHommes();
        //Pagination (utilisable grâce au bundle téléchargé sur github
        $paginator  = $this->get('knp_paginator');
        $paginationActeurs = $paginator->paginate(
            $tousLesHommes,
            $request->query->get('page', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render("TroiswaBackBundle:Acteurs:showActeurs.html.twig", ["hommes"=>$paginationActeurs]);
    } 
    public function listingFemmesAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        //$em équivaut au $connexion em=entity manager
        $tousLesFemmes=$em->getRepository("TroiswaBackBundle:Acteurs")->getAllFemmes();
        //Pagination (utilisable grâce au bundle téléchargé sur github
        $paginator  = $this->get('knp_paginator');
        $paginationActeurs = $paginator->paginate(
            $tousLesFemmes,
            $request->query->get('page', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render("TroiswaBackBundle:Acteurs:showActrices.html.twig", ["femmes"=>$paginationActeurs]);
    }         

    public function getFicheActeurByIDAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $unActeur=$em->getRepository("TroiswaBackBundle:Acteurs")->find($id);   
        if (empty($unActeur))
        {
            throw $this->createNotFoundException("Cette page n'existe pas");
        }
        return $this->render("TroiswaBackBundle:Acteurs:ficheActeur.html.twig", ["unActeur"=>$unActeur]);
    }

    public function createActeurAction(Request $request)
    {
        $nouvelActeur= new Acteurs();
        $nouvelActeur->setDateAjout(new \DateTime('now'));
        $form=$this->createFormBuilder($nouvelActeur)
            ->add("prenom", "text")
            ->add("nom", "text")
            ->add("sexe", "text")
            ->add("bio", "textarea")
            ->add("dateNaissance", "date",
                array(
                    'years' => range(date('Y')-100,date('Y')),
                    'format' => 'dd-MM-yyyy',
                ))

            ->add("ville", "text")
            ->add("fichier", "file", [
                'constraints' => new NotBlank(['message' => "Vous devez choisir une image."])
            ])
            ->add("sexe", "choice", array(
                "choices"   => array("0" => "Homme", "1" => "Femme"),
                'multiple'  => false,
                'expanded'  => true,))
            ->add("liaisonFilms","entity",
            ["class"=>"TroiswaBackBundle:Films",
            "property"=>"titre",
            "multiple"=>true])
            ->add("ajouter", "submit")
            ->getForm();
        if ($request->isMethod("POST"))
        {
            $form->submit($request);
            if ($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();
                $nouvelActeur->upload();
                $em->persist($nouvelActeur);
                $em->flush();
                $showMessageFlash=$request->getSession();
                $showMessageFlash->getFlashBag()->add("success_acteur", "Votre acteur a bien été ajouté.");
                return $this->redirect($this->generateUrl("troiswa_back_listingActeurs"));
            }
        }
        return $this->render("TroiswaBackBundle:Acteurs:createActeur.html.twig", ["formActeur"=>$form->createView()]);
    }
    public function modifActeurAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $acteur=$em->getRepository("TroiswaBackBundle:Acteurs")->find($id);

        $form=$this->createFormBuilder($acteur)
            ->add("prenom", "text")
            ->add("nom", "text")
            ->add("sexe", "text")
            ->add("bio", "textarea")
            ->add("dateNaissance", "date",
            array(
                'years' => range(date('Y')-100,date('Y')),
                'format' => 'dd-MM-yyyy',
            ))
            ->add("ville", "text")
            ->add("fichier", "file")
            ->add("sexe", "choice", array(
                "choices"   => array("0" => "Homme", "1" => "Femme"),
                'multiple'  => false,
                'expanded'  => true,))
            ->add("liaisonFilms","entity",
                ["class"=>"TroiswaBackBundle:Films",
                    "property"=>"titre",
                    "multiple"=>true])
            ->add("modifier", "submit")
            ->getForm();

        if ($request->isMethod("POST"))
        {
            $form->submit($request);
            if ($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();
                $acteur->upload();
                $em->persist($acteur);
                $em->flush();
                $showMessageFlash=$request->getSession();
                $showMessageFlash->getFlashBag()->add("success_acteur", "Votre acteur a bien été modifié.");
                return $this->redirect($this->generateUrl("troiswa_back_listingActeurs"));
            }
        }
        return $this->render("TroiswaBackBundle:Acteurs:modifActeur.html.twig", ["formActeur"=>$form->createView()]);
    }
    public function suppActeurAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $acteur=$em->getRepository("TroiswaBackBundle:Acteurs")->find($id);
        $em->remove($acteur);
        $em->flush();
        $showMessageFlash=$request->getSession();
        $showMessageFlash->getFlashBag()->add("success_acteur", "Votre acteur a bien été supprimé.");
        return $this->redirect($this->generateUrl("troiswa_back_listingActeurs"));
    }
}

<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Films
 *
 * @ORM\Table(name="films")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\FilmsRepository")
 */
class Films
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Vous devez entrer un titre.")
     * @Assert\Length(
     *      min = "1",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères.",)
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     * @Assert\NotBlank(message="Vous devez entrer une description.")
     * @Assert\Length(
     *      max = "300",
     *      maxMessage = "Votre description doit contenir moins de {{ limit }} caractères.",)
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="Vous devez entrer une date de naissance.")
     * @Assert\Date()
     * @ORM\Column(name="dateReal", type="date")
     */
    private $dateReal;

     /**
     * @var \DateTime
     * @ORM\Column(name="dateAjout", type="datetime")
     */
    private $dateAjout;

    /**
     * @var integer
     * @Assert\NotBlank(message="Vous devez entrer une note entre 1 et 5.")
     * @ORM\Column(name="note", type="integer")
     * @Assert\LessThan(
     *     value = 6,
     *     message="La note doit être comprise entre 1 et 5."
     * )
     * @Assert\GreaterThan(
     *     value = 1,
     *     message="La note doit être comprise entre 1 et 5."
     * )
     */
    private $note;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=25)
     */
    private $image;

    /**
     * @var string
     * * @Assert\Image(
     *     minWidth = 500,
     *     minWidthMessage="L'image doit faire plus de 500px de large.",
     *
     *     maxWidth = 1200,
     *     maxWidthMessage="L'image doit faire moins de 1200px de large.",
     *
     *     minHeight = 500,
     *     minHeightMessage="L'image doit faire plus de 500px de haut.",
     *
     *     maxHeight = 1200,
     *     maxHeightMessage="L'image doit faire moins de 1200px de haut.",
     *
     *     maxSize = "1M",
     *     maxSizeMessage="L'image ne doit pas dépasser 1mo.",
     *
     *     mimeTypes={"image/png","image/jpg","image/jpeg"},
     *     mimeTypesMessage="L'image doit être au format JPG ou PNG."
     * )
     */
    private $fichier;


    /**
     * @ORM\ManyToOne(targetEntity="Troiswa\BackBundle\Entity\Genre")
     */
    private $liaisonGenre;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Films
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Films
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateReal
     *
     * @param \DateTime $dateReal
     * @return Films
     */
    public function setDateReal($dateReal)
    {
        $this->dateReal = $dateReal;

        return $this;
    }

    /**
     * Get dateReal
     *
     * @return \DateTime 
     */
    public function getDateReal()
    {
        return $this->dateReal;
    }

        /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     * @return Acteurs
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime 
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }    

    /**
     * Set note
     *
     * @param integer $note
     * @return Films
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Films
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }
    public function displayImage()
    {
        return "assets/images/films/".$this->image;
    }
    public function getLittleDescription($texte, $nbchar = 200)
    {
        return (strlen($texte) > $nbchar ? substr(substr($texte,0,$nbchar),0,strrpos(substr($texte,0,$nbchar)," "))."..." : $texte);
    }

    /**
     * Set liaisonGenre
     *
     * @param \Troiswa\BackBundle\Entity\Genre $liaisonGenre
     * @return Films
     */
    public function setLiaisonGenre(\Troiswa\BackBundle\Entity\Genre $liaisonGenre = null)
    {
        $this->liaisonGenre = $liaisonGenre;

        return $this;
    }

    /**
     * Get liaisonGenre
     *
     * @return \Troiswa\BackBundle\Entity\Genre 
     */
    public function getLiaisonGenre()
    {
        return $this->liaisonGenre;
    }

    public function setFichier($fichier=null)
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getFichier()
    {
        return $this->fichier;
    }

    public function upload()
    {
        if(null===$this->fichier)
        {
            return;
        }
        $nomImage=uniqid()."_".$this->fichier->getClientOriginalName();
        $this->fichier->move(__DIR__."/../../../../web/assets/images/films", $nomImage);
        $this->image=$nomImage;
        $this->fichier=null;
    }
}

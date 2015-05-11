<?php

namespace Troiswa\BackBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acteurs
 *
 * @ORM\Table(name="acteurs")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\ActeursRepository")
 */
class Acteurs
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
     * @Assert\NotBlank(message="Vous devez entrer un prénom.")
     * @Assert\Length(
     *      min = "1",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères.",)
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @var string
     * @Assert\NotBlank(message="Vous devez entrer un nom.")
     * @Assert\Length(
     *      min = "1",
     *      minMessage = "Votre prénom doit faire au moins {{ limit }} caractères.",)
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank(message="Vous devez choisir un sexe.")
     * @Assert\Choice(choices = {"0", "1"}, message = "Choisissez un genre valide.")
     * @ORM\Column(name="sexe", type="boolean")
     */
    private $sexe;

    /**
     * @var string
     * @Assert\NotBlank(message="Vous devez entrer une biographie.")
     * @Assert\Length(
     *      max = "1000",
     *      maxMessage = "La biographie doit contenir moins de {{ limit }} caractères.",)
     * @ORM\Column(name="bio", type="text")
     */
    private $bio;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="Vous devez entrer une date de naissance.")
     * @Assert\Date()
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

     /**
     * @var \DateTime
     * @ORM\Column(name="dateAjout", type="datetime")
     */
    private $dateAjout;

    /**
     * @var string
     * @Assert\NotBlank(message="Vous devez entrer une ville de naissance.")
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

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
     * @ORM\ManyToMany(targetEntity="Troiswa\BackBundle\Entity\Films")
     */
    private $liaisonFilms;


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
     * Set prenom
     *
     * @param string $prenom
     * @return Acteurs
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Acteurs
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set bio
     *
     * @param string $bio
     * @return Acteurs
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string 
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Acteurs
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
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
     * Set ville
     *
     * @param string $ville
     * @return Acteurs
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Acteurs
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

    /**
     * Set sexe
     *
     * @param boolean $sexe
     * @return Acteurs
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return boolean 
     */
    public function getSexe()
    {
        return $this->sexe;
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
        $this->fichier->move(__DIR__."/../../../../web/".$this->getImageFolder(), $nomImage);
        $this->image=$nomImage;
        $this->fichier=null;
    }

    public function displayImage()
    {
        return $this->getImageFolder()."/".$this->image;
    }

    private function getImageFolder()
    {
        return "assets/images/acteurs";
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->liaisonFilms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add liaisonFilms
     *
     * @param \Troiswa\BackBundle\Entity\Films $liaisonFilms
     * @return Acteurs
     */
    public function addLiaisonFilm(\Troiswa\BackBundle\Entity\Films $liaisonFilms)
    {
        $this->liaisonFilms[] = $liaisonFilms;

        return $this;
    }

    /**
     * Remove liaisonFilms
     *
     * @param \Troiswa\BackBundle\Entity\Films $liaisonFilms
     */
    public function removeLiaisonFilm(\Troiswa\BackBundle\Entity\Films $liaisonFilms)
    {
        $this->liaisonFilms->removeElement($liaisonFilms);
    }

    /**
     * Get liaisonFilms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLiaisonFilms()
    {
        return $this->liaisonFilms;
    }
}

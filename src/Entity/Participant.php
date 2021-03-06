<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(fields={"mail"}, message="Cet email est déjà utilisé, avez-vous déjà un compte ?")
 */
class Participant implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     *@ORM\Column(type="string",length=255, nullable=true)
     */
    private $filename;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="participant_image", fileNameProperty="filename")
     * Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $imageFile;

    /**
     * @Assert\NotBlank(message="Il faut remplir la case nom")
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @Assert\NotBlank(message="Il faut remplir la case prénom")
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @Assert\NotBlank(message="Un petit pseudo svp")
     * @ORM\Column(type="string", length=30)
     */
    private $username;

    /**
     * @Assert\NotBlank(message="Votre numéro svp")
     * @Assert\Length(min="10",maxMessage="Un numéro à 10 chiffres",max="10",minMessage="Un numéro à 10 chiffres")
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $telephone;

    /**
     * @Assert\Email(message="Il nous faut un email valide")
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $mail;

    /**
     * @Assert\NotBlank(message="Il vous faut un mot de passe")
     * @Assert\Length(min="8",minMessage="Pour votre sécurité, veuillez mettre un mot de passe à 8 caractères")
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAdmin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActif;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie",mappedBy="organisateur")
     */
    private $sortiesOrganisees;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="participant")
     */
    private $sortiesInscrites;

    public function __construct()
    {
        $this->sortiesOrganisees = new ArrayCollection();
        $this->sortiesInscrites = new ArrayCollection();
    }


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campus",inversedBy="participants")
     */
    private $campus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }



    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function getSortiesOrganisees()
    {
        return $this->sortiesOrganisees;
    }

    public function setSortiesOrganisees($sortiesOrganisees): self
    {
        $this->sortiesOrganisees = $sortiesOrganisees;

        return $this;
    }

    public function getSortiesInscrites()
    {
        return $this->sortiesInscrites;
    }

    public function setSortiesInscrites($sortiesInscrites): self
    {
        $this->sortiesInscrites = $sortiesInscrites;

        return $this;
    }

    public function getCampus()
    {
        return $this->campus;
    }

    public function setCampus($campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return Participant
     */
    public function setFilename(?string $filename): Participant
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Participant
     */
    public function setImageFile(?File $imageFile): Participant
    {
        $this->imageFile = $imageFile;
        return $this;
    }


    public function getRoles()
    {
        return["ROLE_USER"];
    }

    public function eraseCredentials(){}
    public function getSalt(){}

}

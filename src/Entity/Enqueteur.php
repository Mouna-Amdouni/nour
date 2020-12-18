<?php

namespace App\Entity;

use App\Repository\EnqueteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EnqueteurRepository::class)
 * @UniqueEntity(
 * fields={"email"},
 * message="L'email que vous avez indiqué est déjà utilisé !")
 */
class Enqueteur implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $prenom;


    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="enqueteurs")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="Conversation", inversedBy="enqueteurs")
     */
    private $conversation;
    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $motDePasse;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $matriculeFiscale;

    /**
     * @ORM\Column(type="blob",nullable=true)
     */
    private $registreDesCommeerces;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $adresseSociete;

    /**
     * @ORM\Column(type="blob",nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $cin;

    /**
     * @ORM\OneToMany(targetEntity=Sondage::class, mappedBy="enqueteur")
     */
    private $sondages;

    public function __construct()
    {
        $this->sondages = new ArrayCollection();
    }

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getMatriculeFiscale(): ?string
    {
        return $this->matriculeFiscale;
    }

    public function setMatriculeFiscale(string $matriculeFiscale): self
    {
        $this->matriculeFiscale = $matriculeFiscale;

        return $this;
    }

    public function getRegistreDesCommeerces()
    {
        return $this->registreDesCommeerces;
    }

    public function setRegistreDesCommeerces($registreDesCommeerces): self
    {
        $this->registreDesCommeerces = $registreDesCommeerces;

        return $this;
    }

    public function getAdresseSociete(): ?string
    {
        return $this->adresseSociete;
    }

    public function setAdresseSociete(string $adresseSociete): self
    {
        $this->adresseSociete = $adresseSociete;

        return $this;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getGenre(): ?bool
    {
        return $this->genre;
    }

    public function setGenre(bool $genre): self
    {
        $this->genre = $genre;

        return $this;
    }


    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getid();
    }

    /**
     * @return Collection|Sondage[]
     */
    public function getSondages(): Collection
    {
        return $this->sondages;
    }

    public function addSondage(Sondage $sondage): self
    {
        if (!$this->sondages->contains($sondage)) {
            $this->sondages[] = $sondage;
            $sondage->setEnqueteur($this);
        }

        return $this;
    }

    public function removeSondage(Sondage $sondage): self
    {
        if ($this->sondages->removeElement($sondage)) {
            // set the owning side to null (unless already changed)
            if ($sondage->getEnqueteur() === $this) {
                $sondage->setEnqueteur(null);
            }
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->nom;
    }

    public function setUsername(string $username): self
    {
        $this->nom = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->motDePasse;
    }

    public function setPassword(string $password): self
    {
        $this->motDePasse = $password;

        return $this;
    }
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    public function eraseCredentials(){}
    public function getSalt(){}
    public function getRoles():array{
        $roles=$this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getConversation(): ?Conversation
    {
        return $this->conversation;
    }

    public function setConversation(?Conversation $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }
}

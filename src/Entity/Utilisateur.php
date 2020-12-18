<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(
 * fields={"email"},
 * message="L'email que vous avez indiqué est déjà utilisé !")
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motDePasse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $cin;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity=Reponse::class, mappedBy="utilisateur")
     */
    private $reponses;
    /**
     * @ORM\OneToMany(targetEntity="Enqueteur",mappedBy="utilisateur")
     */
    private $enqueteurs;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="utilisateurId")
     */
    private $messagess;



    public function __construct()
    {
        $this->reponses = new ArrayCollection();
        $this->messagess = new ArrayCollection();
        $this->enqueteurs=new  ArrayCollection();
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

    public function setTel(?int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getGenre(): ?bool
    {
        return $this->genre;
    }

    public function setGenre(?bool $genre): self
    {
        $this->genre = $genre;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getid();
    }

    /**
     * @return Collection|Reponse[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setUtilisateur($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getUtilisateur() === $this) {
                $reponse->setUtilisateur(null);
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

    public function eraseCredentials(){}
    public function getSalt(){}
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    /**
     * @return Collection|Enqueteur[]
     */
    public function getEnqueteurs(): Collection
    {
        return $this->enqueteurs;
    }

    public function addEnqueteur(Enqueteur $enqueteur): self
    {
        if (!$this->enqueteurs->contains($enqueteur)) {
            $this->enqueteurs[] = $enqueteur;
            $enqueteur->setUtilisateur($this);
        }

        return $this;
    }

    public function removeEnqueteur(Enqueteur $enqueteur): self
    {
        if ($this->enqueteurs->contains($enqueteur)) {
            $this->enqueteurs->removeElement($enqueteur);
            // set the owning side to null (unless already changed)
            if ($enqueteur->getUtilisateur() === $this) {
                $enqueteur->setUtilisateur(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Message[]
     */
    public function getMessagess(): Collection
    {
        return $this->messagess;
    }

    public function addMessagess(Message $messagess): self
    {
        if (!$this->messagess->contains($messagess)) {
            $this->messagess[] = $messagess;
            $messagess->setUtilisateur($this);
        }

        return $this;
    }

    public function removeMessagess(Message $messagess): self
    {
        if ($this->messagess->removeElement($messagess)) {
            // set the owning side to null (unless already changed)
            if ($messagess->getUtilisateur() === $this) {
                $messagess->setUtilisateur(null);
            }
        }

        return $this;
    }
}

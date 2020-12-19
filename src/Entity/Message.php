<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Index;
/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ORM\Table(indexes={@Index(name="created_at_index", columns={"created_at"})})
 * @HasLifecycleCallbacks()
 */
class Message
{
    use Timestamp;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;




    /**
     * @ORM\ManyToOne(targetEntity=Conversation::class, inversedBy="message")
     */
    private $utilisateur;



    /**
     * @ORM\ManyToOne(targetEntity=Conversation::class, inversedBy="lastMessageId")
     */
    private $conversation;


    private $mine;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
    public function getUtilisateur(): ?Utilisateur
    {

        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
  
    public function __toString(){
        // to show the name of the Category in the select
        return $this->content;
        // to show the id of the Category in the select
        // return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMine()
    {
        return $this->mine;
    }

    /**
     * @param mixed $mine
     */
    public function setMine($mine): void
    {
        $this->mine = $mine;
    }


}

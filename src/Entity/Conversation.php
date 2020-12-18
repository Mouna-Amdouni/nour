<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ConversationRepository")
 * @ORM\Table(indexes={@Index(name="last_message_id_index",columns={"last_message_id"})})

 */

class Conversation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */


    private $id;
    /**
     * @ORM\OneToMany(targetEntity=Enqueteur::class, mappedBy="conversation")
     */
    private $enqueteurs;

    /**
     * @ORM\OneToOne(targetEntity=Message::class)
     * @ORM\JoinColumn(name="last_message_id", referencedColumnName="id")
     */
    private $lastMessage;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="conversation")
     */
    private $messages;

    public function __construct()
    {
        $this->enqueteurs = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $enqueteur->setConversation($this);
        }

        return $this;
    }

    public function removeEnqueteur(Enqueteur $enqueteur): self
    {
        if ($this->enqueteurs->contains($enqueteur)) {
            $this->enqueteurs->removeElement($enqueteur);
            // set the owning side to null (unless already changed)
            if ($enqueteur->getConversation() === $this) {
                $enqueteur->setConversation(null);
            }
        }

        return $this;
    }

    public function getLastMessage(): ?Message
    {
        return $this->lastMessage;
    }

    public function setLastMessage(?Message $lastMessage): self
    {
        $this->lastMessage = $lastMessage;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setConversation($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getConversation() === $this) {
                $message->setConversation(null);
            }
        }

        return $this;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return $this->id;
        // to show the id of the Category in the select
        // return $this->id;
    }
}

<?php

namespace App\Entity;

use App\Repository\DirectMessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DirectMessageRepository::class)
 */
class DirectMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $messageDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $vue;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="directMessages")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="directMessages")
     */
    private $receiver;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMessageDate(): ?\DateTimeInterface
    {
        return $this->messageDate;
    }

    public function setMessageDate(?\DateTimeInterface $messageDate): self
    {
        $this->messageDate = $messageDate;

        return $this;
    }

    public function getVue(): ?int
    {
        return $this->vue;
    }

    public function setVue(int $vue): self
    {
        $this->vue = $vue;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }
}

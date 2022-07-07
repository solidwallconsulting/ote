<?php

namespace App\Entity;

use App\Repository\SocialMediasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocialMediasRepository::class)
 */
class SocialMedias
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
    private $icon;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=PartnerSocialMedias::class, mappedBy="socialMedia")
     */
    private $partnerSocialMedias;

    public function __construct()
    {
        $this->partnerSocialMedias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, PartnerSocialMedias>
     */
    public function getPartnerSocialMedias(): Collection
    {
        return $this->partnerSocialMedias;
    }

    public function addPartnerSocialMedia(PartnerSocialMedias $partnerSocialMedia): self
    {
        if (!$this->partnerSocialMedias->contains($partnerSocialMedia)) {
            $this->partnerSocialMedias[] = $partnerSocialMedia;
            $partnerSocialMedia->setSocialMedia($this);
        }

        return $this;
    }

    public function removePartnerSocialMedia(PartnerSocialMedias $partnerSocialMedia): self
    {
        if ($this->partnerSocialMedias->removeElement($partnerSocialMedia)) {
            // set the owning side to null (unless already changed)
            if ($partnerSocialMedia->getSocialMedia() === $this) {
                $partnerSocialMedia->setSocialMedia(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->name;
    }
}

<?php

namespace App\Entity;

use App\Repository\PartnerSocialMediasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartnerSocialMediasRepository::class)
 */
class PartnerSocialMedias
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SocialMedias::class, inversedBy="partnerSocialMedias")
     */
    private $socialMedia;

    /**
     * @ORM\Column(type="text")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Partners::class, inversedBy="partnerSocialMedias")
     */
    private $partner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocialMedia(): ?SocialMedias
    {
        return $this->socialMedia;
    }

    public function setSocialMedia(?SocialMedias $socialMedia): self
    {
        $this->socialMedia = $socialMedia;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPartner(): ?Partners
    {
        return $this->partner;
    }

    public function setPartner(?Partners $partner): self
    {
        $this->partner = $partner;

        return $this;
    }
}

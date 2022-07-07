<?php

namespace App\Entity;

use App\Repository\PartnersUtilsDocsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartnersUtilsDocsRepository::class)
 */
class PartnersUtilsDocs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Partners::class, inversedBy="partnersUtilsDocs")
     */
    private $partner;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $docURL;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDocURL(): ?string
    {
        return $this->docURL;
    }

    public function setDocURL(?string $docURL): self
    {
        $this->docURL = $docURL;

        return $this;
    }
}

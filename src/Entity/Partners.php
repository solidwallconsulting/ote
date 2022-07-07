<?php

namespace App\Entity;

use App\Repository\PartnersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartnersRepository::class)
 */
class Partners
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logoURL;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;
 
 

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="partners")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="partners")
     */
    private $region;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $views;

 

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $youtubeFrame;

    /**
     * @ORM\Column(type="text")
     */
    private $about;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverImageURL;

    /**
     * @ORM\OneToMany(targetEntity=PartnerSocialMedias::class, mappedBy="partner")
     */
    private $partnerSocialMedias;

    /**
     * @ORM\OneToMany(targetEntity=PartnersUtilsDocs::class, mappedBy="partner")
     */
    private $partnersUtilsDocs;

    /**
     * @ORM\OneToMany(targetEntity=PartnersUtilLinkes::class, mappedBy="partner")
     */
    private $partnersUtilLinkes;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="partners", cascade={"persist", "remove"})
     */
    private $user;

 

    public function __construct()
    {
        $this->partnerSocialMedias = new ArrayCollection();
        $this->partnersUtilsDocs = new ArrayCollection();
        $this->partnersUtilLinkes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLogoURL(): ?string
    {
        return $this->logoURL;
    }

    public function setLogoURL(string $logoURL): self
    {
        $this->logoURL = $logoURL;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(?string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    

    public function __toString()
    {
        return $this->name;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): self
    {
        $this->views = $views;

        return $this;
    }

    

    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    public function setPhone2(?string $phone2): self
    {
        $this->phone2 = $phone2;

        return $this;
    }

    public function getYoutubeFrame(): ?string
    {
        return $this->youtubeFrame;
    }

    public function setYoutubeFrame(?string $youtubeFrame): self
    {
        $this->youtubeFrame = $youtubeFrame;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function getCoverImageURL(): ?string
    {
        return $this->coverImageURL;
    }

    public function setCoverImageURL(?string $coverImageURL): self
    {
        $this->coverImageURL = $coverImageURL;

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
            $partnerSocialMedia->setPartner($this);
        }

        return $this;
    }

    public function removePartnerSocialMedia(PartnerSocialMedias $partnerSocialMedia): self
    {
        if ($this->partnerSocialMedias->removeElement($partnerSocialMedia)) {
            // set the owning side to null (unless already changed)
            if ($partnerSocialMedia->getPartner() === $this) {
                $partnerSocialMedia->setPartner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PartnersUtilsDocs>
     */
    public function getPartnersUtilsDocs(): Collection
    {
        return $this->partnersUtilsDocs;
    }

    public function addPartnersUtilsDoc(PartnersUtilsDocs $partnersUtilsDoc): self
    {
        if (!$this->partnersUtilsDocs->contains($partnersUtilsDoc)) {
            $this->partnersUtilsDocs[] = $partnersUtilsDoc;
            $partnersUtilsDoc->setPartner($this);
        }

        return $this;
    }

    public function removePartnersUtilsDoc(PartnersUtilsDocs $partnersUtilsDoc): self
    {
        if ($this->partnersUtilsDocs->removeElement($partnersUtilsDoc)) {
            // set the owning side to null (unless already changed)
            if ($partnersUtilsDoc->getPartner() === $this) {
                $partnersUtilsDoc->setPartner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PartnersUtilLinkes>
     */
    public function getPartnersUtilLinkes(): Collection
    {
        return $this->partnersUtilLinkes;
    }

    public function addPartnersUtilLinke(PartnersUtilLinkes $partnersUtilLinke): self
    {
        if (!$this->partnersUtilLinkes->contains($partnersUtilLinke)) {
            $this->partnersUtilLinkes[] = $partnersUtilLinke;
            $partnersUtilLinke->setPartner($this);
        }

        return $this;
    }

    public function removePartnersUtilLinke(PartnersUtilLinkes $partnersUtilLinke): self
    {
        if ($this->partnersUtilLinkes->removeElement($partnersUtilLinke)) {
            // set the owning side to null (unless already changed)
            if ($partnersUtilLinke->getPartner() === $this) {
                $partnersUtilLinke->setPartner(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}

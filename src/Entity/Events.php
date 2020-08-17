<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventsRepository::class)
 */
class Events
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
    private $websiteLink;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $place;

    /**
     * @ORM\Column(type="date")
     */
    private $launchDate;

    /**
     * @ORM\Column(type="date")
     */
    private $stopDate;

    /**
     * @ORM\Column(type="text")
     */
    private $shortDesc;


    /**
     * @ORM\Column(type="text")
     */
    private $longDesc;
    
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity=SocialLinks::class, inversedBy="events")
     */
    private $socialLinks;

    /**
     * @ORM\ManyToMany(targetEntity=AvailableGames::class, inversedBy="events")
     */
    private $availableGames;

    /**
     * @ORM\OneToMany(targetEntity=EventReviews::class, mappedBy="events")
     */
    private $reviews;

    /**
     * @ORM\ManyToOne(targetEntity=EventCategory::class, inversedBy="events")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="events")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ticketNumber;

    public function __construct()
    {
        $this->socialLinks = new ArrayCollection();
        $this->availableGames = new ArrayCollection();
        $this->reviews = new ArrayCollection();
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

    public function getWebsiteLink(): ?string
    {
        return $this->websiteLink;
    }

    public function setWebsiteLink(string $websiteLink): self
    {
        $this->websiteLink = $websiteLink;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getLaunchDate(): ?\DateTimeInterface
    {
        return $this->launchDate;
    }

    public function setLaunchDate(\DateTimeInterface $launchDate): self
    {
        $this->launchDate = $launchDate;

        return $this;
    }

    public function getStopDate(): ?\DateTimeInterface
    {
        return $this->stopDate;
    }

    public function setStopDate(\DateTimeInterface $stopDate): self
    {
        $this->stopDate = $stopDate;

        return $this;
    }

    public function getShortDesc(): ?string
    {
        return $this->shortDesc;
    }

    public function setShortDesc(string $shortDesc): self
    {
        $this->shortDesc = $shortDesc;

        return $this;
    }

    public function getLongDesc(): ?string
    {
        return $this->longDesc;
    }

    public function setLongDesc(string $longDesc): self
    {
        $this->longDesc = $longDesc;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|SocialLinks[]
     */
    public function getSocialLinks(): Collection
    {
        return $this->socialLinks;
    }

    public function addSocialLink(SocialLinks $socialLink): self
    {
        if (!$this->socialLinks->contains($socialLink)) {
            $this->socialLinks[] = $socialLink;
        }

        return $this;
    }

    public function removeSocialLink(SocialLinks $socialLink): self
    {
        if ($this->socialLinks->contains($socialLink)) {
            $this->socialLinks->removeElement($socialLink);
        }

        return $this;
    }

    /**
     * @return Collection|AvailableGames[]
     */
    public function getAvailableGames(): Collection
    {
        return $this->availableGames;
    }

    public function addAvailableGame(AvailableGames $availableGame): self
    {
        if (!$this->availableGames->contains($availableGame)) {
            $this->availableGames[] = $availableGame;
        }

        return $this;
    }

    public function removeAvailableGame(AvailableGames $availableGame): self
    {
        if ($this->availableGames->contains($availableGame)) {
            $this->availableGames->removeElement($availableGame);
        }

        return $this;
    }

    /**
     * @return Collection|EventReviews[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(EventReviews $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setEvents($this);
        }

        return $this;
    }

    public function removeReview(EventReviews $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getEvents() === $this) {
                $review->setEvents(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?EventCategory
    {
        return $this->category;
    }

    public function setCategory(?EventCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTicketNumber(): ?int
    {
        return $this->ticketNumber;
    }

    public function setTicketNumber(int $ticketNumber): self
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }
}

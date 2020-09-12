<?php

namespace App\Entity;

use App\Repository\AvailableGamesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvailableGamesRepository::class)
 */
class AvailableGames
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
    private $gameName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gameUrl;

    /**
     * @ORM\ManyToMany(targetEntity=Events::class, mappedBy="availableGames")
     */
    private $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->searchEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameName(): ?string
    {
        return $this->gameName;
    }

    public function setGameName(string $gameName): self
    {
        $this->gameName = $gameName;

        return $this;
    }

    public function getGameUrl(): ?string
    {
        return $this->gameUrl;
    }

    public function setGameUrl(?string $gameUrl): self
    {
        $this->gameUrl = $gameUrl;

        return $this;
    }

    /**
     * @return Collection|Events[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addAvailableGame($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeAvailableGame($this);
        }

        return $this;
    }
}

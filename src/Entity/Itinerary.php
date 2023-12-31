<?php

namespace App\Entity;

use App\Repository\ItineraryRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=ItineraryRepository::class)
 */
class Itinerary
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=PointOfInterest::class, mappedBy="itinerary", cascade={"persist", "remove"})
     */
    private $pointsOfInterest;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="itinerary")
     */
    private $articles;

    public function __construct()
    {
        $this->pointsOfInterest = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|PointOfInterest[]
     */
    public function getPointsOfInterest(): Collection
    {
        return $this->pointsOfInterest;
    }

    /**
     * @param PointOfInterest $pointOfInterest
     */
    public function addPointOfInterest(PointOfInterest $pointOfInterest): self
    {
        if (!$this->pointsOfInterest->contains($pointOfInterest)) {
            $this->pointsOfInterest[] = $pointOfInterest;
            $pointOfInterest->setItinerary($this);
        }

        return $this;
    }

    /**
     * @param PointOfInterest $pointOfInterest
     */
    public function removePointOfInterest(PointOfInterest $pointOfInterest): self
    {
        if ($this->pointsOfInterest->removeElement($pointOfInterest)) {
            // set the owning side to null (unless already changed)
            if ($pointOfInterest->getItinerary() === $this) {
                $pointOfInterest->setItinerary(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setItinerary($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getItinerary() === $this) {
                $article->setItinerary(null);
            }
        }

        return $this;
    }
}

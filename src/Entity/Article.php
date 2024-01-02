<?php

namespace App\Entity;

use Assert\NotBlank;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 * @ApiResource(normalizationContext={"groups"={"read:article"}})
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le titre ne peut pas être vide.")
     * @groups({"read:article"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Le contenu ne peut pas être vide.")
     * @groups({"read:article"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Itinerary::class, inversedBy="articles")
     * @groups({"read:article"})
     */
    private $itinerary;

    /**
     * @ORM\OneToMany(targetEntity=SocialShare::class, mappedBy="article")
     */
    private $socialShares;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=true)
     * @groups({"read:article"})
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="article", orphanRemoval=true)
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     * @groups({"read:article"})
     */
    private $category;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @groups({"read:article"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=View::class, mappedBy="article")
     */
    private $views;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;


    /**
     * @Vich\UploadableField(mapping="articles", fileNameProperty="file")
     * @Assert\Image(
     *     maxSize="5M",
     *     maxSizeMessage="La taille de l'image ne doit pas dépasser 5 Mo.",
     *     mimeTypes={"image/jpeg", "image/png"},
     *     mimeTypesMessage="Veuillez télécharger une image au format JPEG ou PNG."
     * )
     * @Groups({"read:article"})
     * @var File|null
     */
    private $imageFile;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->setCreatedAt(new \DateTimeImmutable());
        $this->setUpdatedAt(new \DateTimeImmutable());
        $this->socialShares = new ArrayCollection();
        $this->views = new ArrayCollection();
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


    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }


    public function getItinerary(): ?Itinerary
    {
        return $this->itinerary;
    }

    public function setItinerary(?Itinerary $itinerary): self
    {
        $this->itinerary = $itinerary;

        return $this;
    }

    public function addSocialShare(SocialShare $socialShare): self
    {
        if (!$this->socialShares->contains($socialShare)) {
            $this->socialShares[] = $socialShare;
            $socialShare->setArticle($this);
        }

        return $this;
    }

    public function removeSocialShare(SocialShare $socialShare): self
    {
        if ($this->socialShares->removeElement($socialShare)) {
            // set the owning side to null (unless already changed)
            if ($socialShare->getArticle() === $this) {
                $socialShare->setArticle(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setTimestamps(): void
    {
        $this->updated_at = new \DateTimeImmutable();
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

    /**
     * @return Collection<int, View>
     */
    public function getViews(): Collection
    {
        return $this->views;
    }

    public function addView(View $view): self
    {
        if (!$this->views->contains($view)) {
            $this->views[] = $view;
            $view->setArticle($this);
        }

        return $this;
    }

    public function removeView(View $view): self
    {
        if ($this->views->removeElement($view)) {
            // set the owning side to null (unless already changed)
            if ($view->getArticle() === $this) {
                $view->setArticle(null);
            }
        }

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get the value of imageFile
     *
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param File|null $imageFile
     * @return self
     */
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    /**
     * @return Collection<int, SocialShare>
     */
    public function getSocialShares(): Collection
    {
        return $this->socialShares;
    }
}

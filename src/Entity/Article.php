<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\NotBlank()
     * @Assert\Length(max=80)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\GreaterThanOrEqual(value="today")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=10)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $writtenBy;

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

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

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

    public function getWrittenBy(): ?Author
    {
        return $this->writtenBy;
    }

    public function setWrittenBy(?Author $writtenBy): self
    {
        $this->writtenBy = $writtenBy;

        return $this;
    }

    /**
     * @Assert\IsTrue(message="Il faut plus de contenu que de titre")
     */
    public function isContentLongerThanTitle(): bool
    {
        return mb_strlen($this->content) > mb_strlen($this->title);
    }
}

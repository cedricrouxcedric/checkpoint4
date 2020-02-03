<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PerformanceRepository")
 */
class Performance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypePerformance", inversedBy="performance")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wilder", mappedBy="performance")
     */
    private $wilder;

    public function __construct()
    {
        $this->wilder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getType(): ?TypePerformance
    {
        return $this->type;
    }

    public function setType(?TypePerformance $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Wilder[]
     */
    public function getWilder(): Collection
    {
        return $this->wilder;
    }

    public function addWilder(Wilder $wilder): self
    {
        if (!$this->wilder->contains($wilder)) {
            $this->wilder[] = $wilder;
            $wilder->setPerformance($this);
        }

        return $this;
    }

    public function removeWilder(Wilder $wilder): self
    {
        if ($this->wilder->contains($wilder)) {
            $this->wilder->removeElement($wilder);
            // set the owning side to null (unless already changed)
            if ($wilder->getPerformance() === $this) {
                $wilder->setPerformance(null);
            }
        }

        return $this;
    }
}

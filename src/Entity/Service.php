<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
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
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Employer", mappedBy="service")
     */
    private $employer;

    public function __construct()
    {
        $this->employer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Employer[]
     */
    public function getEmployer(): Collection
    {
        return $this->employer;
    }

    public function addEmployer(Employer $employer): self
    {
        if (!$this->employer->contains($employer)) {
            $this->employer[] = $employer;
            $employer->setService($this);
        }

        return $this;
    }

    public function removeEmployer(Employer $employer): self
    {
        if ($this->employer->contains($employer)) {
            $this->employer->removeElement($employer);
            // set the owning side to null (unless already changed)
            if ($employer->getService() === $this) {
                $employer->setService(null);
            }
        }

        return $this;
    }
}

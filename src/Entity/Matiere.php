<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MatiereRepository::class)
 */
class Matiere
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le nom ne doit pas etre vide ")
     */
    private $nomM;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le prix ne doit pas etre vide ")
     */
    private $prixM;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgSrc;

    /**
     * @ORM\OneToMany(targetEntity=Cours::class, mappedBy="matiere")
     */
    private $courses;

    /**
     * @ORM\OneToMany(targetEntity=Course::class, mappedBy="matiere")
     */
    private $test;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->test = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomM(): ?string
    {
        return $this->nomM;
    }

    public function setNomM(string $nomM): self
    {
        $this->nomM = $nomM;

        return $this;
    }

    public function getPrixM(): ?string
    {
        return $this->prixM;
    }

    public function setPrixM(string $prixM): self
    {
        $this->prixM = $prixM;

        return $this;
    }

    public function getImgSrc(): ?string
    {
        return $this->imgSrc;
    }

    public function setImgSrc(string $imgSrc): self
    {
        $this->imgSrc = $imgSrc;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }

    /**
     * @return Collection|Cours[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Cours $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setMatiere($this);
        }

        return $this;
    }

    public function removeCourse(Cours $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getMatiere() === $this) {
                $course->setMatiere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getTest(): Collection
    {
        return $this->test;
    }

    public function addTest(Course $test): self
    {
        if (!$this->test->contains($test)) {
            $this->test[] = $test;
            $test->setMatiere($this);
        }

        return $this;
    }

    public function removeTest(Course $test): self
    {
        if ($this->test->removeElement($test)) {
            // set the owning side to null (unless already changed)
            if ($test->getMatiere() === $this) {
                $test->setMatiere(null);
            }
        }

        return $this;
    }
}

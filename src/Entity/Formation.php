<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormationRepository")
 */
class Formation
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
    private $title;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $code;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cours", mappedBy="formations")
     */
    private $Courses;

    public function __construct()
    {
        $this->Courses = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|Cours[]
     */
    public function getCourses(): Collection
    {
        return $this->Courses;
    }

    public function addCourse(Cours $course): self
    {
        if (!$this->Courses->contains($course)) {
            $this->Courses[] = $course;
        }

        return $this;
    }

    public function removeCourse(Cours $course): self
    {
        if ($this->Courses->contains($course)) {
            $this->Courses->removeElement($course);
        }

        return $this;
    }
}

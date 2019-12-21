<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursRepository")
 */
class Cours
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
     * @ORM\Column(type="integer")
     */
    private $id_moodle;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Teacher", inversedBy="cours")
     */
    private $teachers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Discipline", inversedBy="cours")
     */
    private $discipline;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Concours", inversedBy="cours")
     */
    private $concours;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->teachers = new ArrayCollection();
        $this->concours = new ArrayCollection();
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

    public function getIdMoodle(): ?int
    {
        return $this->id_moodle;
    }

    public function setIdMoodle(int $id_moodle): self
    {
        $this->id_moodle = $id_moodle;

        return $this;
    }

    /**
     * @return Collection|Teacher[]
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teacher $teacher): self
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers[] = $teacher;
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): self
    {
        if ($this->teachers->contains($teacher)) {
            $this->teachers->removeElement($teacher);
        }

        return $this;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): self
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * @return Collection|Concours[]
     */
    public function getConcours(): Collection
    {
        return $this->concours;
    }

    public function addConcour(Concours $concour): self
    {
        if (!$this->concours->contains($concour)) {
            $this->concours[] = $concour;
        }

        return $this;
    }

    public function removeConcour(Concours $concour): self
    {
        if ($this->concours->contains($concour)) {
            $this->concours->removeElement($concour);
        }

        return $this;
    }
}

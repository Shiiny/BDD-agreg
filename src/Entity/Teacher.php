<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TeacherRepository")
 * @UniqueEntity(fields={"id_moodle"}, message="Cet id_moodle est déjà utilisé")
 */
class Teacher
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @Assert\Email(message="l'E-mail '{{ value }}' n'est pas valide")
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_moodle;

   /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Discipline", inversedBy="teachers")
     */
    private $discipline;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cours", mappedBy="teachers")
     */
    private $cours;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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
     * @return Collection|Cours[]
     */

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
     * @return Collection|Cours[]
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
            $cour->addTeacher($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
            $cour->removeTeacher($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->lastname.' '.$this->firstname;
    }

    /**
     * @return string
     */
    public function getNameFormated()
    {
        $partsName = explode(" ", $this->getLastname());
        if (count($partsName) > 1) {
            $nameFormated = htmlentities(implode('_',$partsName));
            $nameFormated = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $nameFormated);
            $nameFormated = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $nameFormated);
            $nameFormated = preg_replace( '#&[^;]+;#', '', $nameFormated);

            return $nameFormated;
        }
        return $this->getLastname();
    }

}

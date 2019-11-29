<?php


namespace App\Entity;


class BddSearch
{
    /**
     * @var string|null
     */
    private $teacher;

    /**
     * @var string|null
     */
    private $cours;

    /**
     * @return string|null
     */
    public function getTeacher(): ?string
    {
        return $this->teacher;
    }

    /**
     * @param string|null $teacher
     * @return BddSearch
     */
    public function setTeacher(string $teacher): BddSearch
    {
        $this->teacher = $teacher;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCours(): ?string
    {
        return $this->cours;
    }

    /**
     * @param string|null $cours
     * @return BddSearch
     */
    public function setCours(string $cours): BddSearch
    {
        $this->cours = $cours;
        return $this;
    }

}
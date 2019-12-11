<?php


namespace App\Data;


use App\Entity\Formation;
use App\Entity\Teacher;

class SearchData
{
    /**
     * @var string
     */
    public $cours;

    /**
     * @var null|Teacher
     */
    public $teacher;

    /**
     * @var null|Formation
     */
    public $formation;

}
<?php


namespace App\Data;


use App\Entity\Concours;
use App\Entity\Teacher;

class SearchData
{
    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $cours;

    /**
     * @var null|Teacher
     */
    public $teacher;

    /**
     * @var null|Concours
     */
    public $formation;

}
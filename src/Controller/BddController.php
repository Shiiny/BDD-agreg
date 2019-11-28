<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BddController extends AbstractController
{
    /**
     * @var TeacherRepository
     */
    private $teacher_repo;

    public function __construct(TeacherRepository $teacher_repo)
    {
        $this->teacher_repo = $teacher_repo;
    }


    /**
     * @Route("/", name="bdd")
     */
    public function index()
    {

        $teacher = $this->teacher_repo->find(6);
        dump($teacher);

        return $this->render('bdd/index.html.twig', [
            'teachers' => $teacher,
        ]);
    }
}

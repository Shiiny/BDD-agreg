<?php

namespace App\Controller\Admin;

use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
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
     * @Route("/admin", name="admin.index")
     */
    public function index()
    {
        $teachers = $this->teacher_repo->findByLimite(10);
        return $this->render('bdd/admin/home.html.twig', compact('teachers'));
    }

}
<?php

namespace App\Controller\Admin;

use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/", name="admin.index")
     * @param TeacherRepository $teacherRepository
     * @return Response
     */
    public function index(TeacherRepository $teacherRepository): Response
    {
        return $this->render('bdd/admin/home.html.twig', [
            'teachers' => $teacherRepository->findByLimite(10)
        ]);
    }

}
<?php

namespace App\Controller\Admin;

use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/", name="admin.index")
     * @param TeacherRepository $tr
     * @return Response
     */
    public function index(TeacherRepository $tr): Response
    {
        return $this->render('bdd/admin/home.html.twig', [
            'teachers' => $tr->findByLimite(10)
        ]);
    }

}
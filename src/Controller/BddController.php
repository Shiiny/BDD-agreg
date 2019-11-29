<?php

namespace App\Controller;

use App\Entity\BddSearch;
use App\Entity\Cours;
use App\Entity\Teacher;
use App\Form\BddSearchType;
use App\Form\CoursType;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/search/{param}", name="bdd.search.teacher")
     *
     */
    public function index(Request $request)
    {
        $search = new BddSearch();
        $cours = new Cours();

        $form = $this->createForm(BddSearchType::class, $search);
        $formCours = $this->createForm(CoursType::class, $cours);

        $form->handleRequest($request);
        $formCours->handleRequest($request);


        if ($form->isSubmitted()) {
            $teacher = $this->teacher_repo->findByParam($search);
            dump($teacher);

            return $this->render('bdd/index.html.twig', [
                'teacher' => $teacher,
                'form' => $form->createView()
            ]);
        }


        return $this->render('bdd/index.html.twig', [
            'form' => $form->createView(),
            'formCours' => $formCours->createView()
        ]);
    }
}

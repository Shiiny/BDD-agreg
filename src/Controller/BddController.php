<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchCoursForm;
use App\Form\SearchTeacherForm;
use App\Form\SearchFormationForm;
use App\Repository\ConcoursRepository;
use App\Repository\CoursRepository;
use App\Repository\FormationRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BddController extends AbstractController
{


    /**
     * @var TeacherRepository
     */
    private $tr;
    /**
     * @var ConcoursRepository
     */
    private $ccr;
    /**
     * @var CoursRepository
     */
    private $cr;

    public function __construct(TeacherRepository $tr, ConcoursRepository $ccr, CoursRepository $cr)
    {
        $this->tr = $tr;
        $this->ccr = $ccr;
        $this->cr = $cr;
    }


    /**
     * @Route("/", name="bdd")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $data = new SearchData();

        $formTeacher = $this->createForm(SearchTeacherForm::class, $data);
        $formCours = $this->createForm(SearchCoursForm::class, $data);
        $formConcours = $this->createForm(SearchFormationForm::class, $data);


        $formTeacher->handleRequest($request);
        $formCours->handleRequest($request);
        $formConcours->handleRequest($request);


        if ($formTeacher->isSubmitted()) {
            $teacher = $this->tr->findSearch($data);

            //dd($teacher);

            return $this->render('bdd/index.html.twig', [
                'formTeacher' => $formTeacher->createView(),
                'formCours' => $formCours->createView(),
                'formFormation' => $formConcours->createView(),
                'teacher' => $teacher,
            ]);
        }

        if ($formConcours->isSubmitted()) {
            $formation = $this->ccr->findSearch($data);

            return $this->render('bdd/index.html.twig', [
                'formTeacher' => $formTeacher->createView(),
                'formCours' => $formCours->createView(),
                'formFormation' => $formConcours->createView(),
                'formation' => $formation,
            ]);
        }

        if ($formCours->isSubmitted()) {
            $courses = $this->cr->findSearch($data);

            return $this->render('bdd/index.html.twig', [
                'formTeacher' => $formTeacher->createView(),
                'formCours' => $formCours->createView(),
                'formFormation' => $formConcours->createView(),
                'courses' => $courses,
                'data' => $data->cours
            ]);
        }

        return $this->render('bdd/index.html.twig', [
            'formTeacher' => $formTeacher->createView(),
            'formCours' => $formCours->createView(),
            'formFormation' => $formConcours->createView()
        ]);
    }
}

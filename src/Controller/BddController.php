<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Cours;
use App\Entity\Formation;
use App\Entity\Teacher;
use App\Form\SearchCoursForm;
use App\Form\SearchTeacherForm;
use App\Form\SearchFormationForm;
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
    private $teacherRepository;
    /**
     * @var FormationRepository
     */
    private $formationRepository;
    /**
     * @var CoursRepository
     */
    private $coursRepository;

    public function __construct(TeacherRepository $teacherRepository, FormationRepository $formationRepository, CoursRepository $coursRepository)
    {
        $this->teacherRepository = $teacherRepository;
        $this->formationRepository = $formationRepository;
        $this->coursRepository = $coursRepository;
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
        $formFormation = $this->createForm(SearchFormationForm::class, $data);


        $formTeacher->handleRequest($request);
        $formCours->handleRequest($request);
        $formFormation->handleRequest($request);


        if ($formTeacher->isSubmitted()) {
            $teacher = $this->teacherRepository->findSearch($data);

            return $this->render('bdd/index.html.twig', [
                'formTeacher' => $formTeacher->createView(),
                'formCours' => $formCours->createView(),
                'formFormation' => $formFormation->createView(),
                'teacher' => $teacher,
            ]);
        }

        if ($formFormation->isSubmitted()) {
            $formation = $this->formationRepository->findSearch($data);

            return $this->render('bdd/index.html.twig', [
                'formTeacher' => $formTeacher->createView(),
                'formCours' => $formCours->createView(),
                'formFormation' => $formFormation->createView(),
                'formation' => $formation,
            ]);
        }

        if ($formCours->isSubmitted()) {
            $courses = $this->coursRepository->findSearch($data);
            dump($courses);

            return $this->render('bdd/index.html.twig', [
                'formTeacher' => $formTeacher->createView(),
                'formCours' => $formCours->createView(),
                'formFormation' => $formFormation->createView(),
                'courses' => $courses,
                'data' => $data->cours
            ]);
        }

        return $this->render('bdd/index.html.twig', [
            'formTeacher' => $formTeacher->createView(),
            'formCours' => $formCours->createView(),
            'formFormation' => $formFormation->createView()
        ]);
    }
}

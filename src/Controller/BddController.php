<?php

namespace App\Controller;

use App\Entity\BddSearch;
use App\Entity\Cours;
use App\Entity\Formation;
use App\Entity\Teacher;
use App\Form\CoursSearchType;
use App\Form\TeacherSearchType;
use App\Form\CoursType;
use App\Form\SelectFormationType;
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
    private $teacher_repository;
    /**
     * @var FormationRepository
     */
    private $formationRepository;
    /**
     * @var CoursRepository
     */
    private $coursRepository;

    public function __construct(TeacherRepository $teacher_repository, FormationRepository $formationRepository, CoursRepository $coursRepository)
    {
        $this->teacher_repository = $teacher_repository;
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
        $search = new BddSearch();


        $formTeacher = $this->createForm(TeacherSearchType::class);
        $formCours = $this->createForm(CoursSearchType::class, $search);
        $formFormation = $this->createForm(SelectFormationType::class);


        $formTeacher->handleRequest($request);
        $formCours->handleRequest($request);
        $formFormation->handleRequest($request);

        if ($formTeacher->isSubmitted()) {
            $teacher = $this->teacher_repository->findOneBy(['id'=>$request->get('teacher')]);
            $subCourses = $this->coursRepository->findByTeacher($teacher);

            $path = "\\\NAS-AGREG\\commun\\Enseignants_Services\\Services_Anglais\\";
            $query = $path . $teacher->getLastname() . "_fiche_service.xlsx";


            return $this->render('bdd/index.html.twig', [
                'formTeacher' => $formTeacher->createView(),
                'formCours' => $formCours->createView(),
                'formFormation' => $formFormation->createView(),
                'teacher' => $teacher,
                'query' => $query,
                'subCourses' => $subCourses,
            ]);
        }

        if ($formFormation->isSubmitted()) {
            $forma = $this->formationRepository->findOneBy(['code'=>$request->get('formation')]);
            $courses = $this->coursRepository->findAllByFormation($forma);


            return $this->render('bdd/index.html.twig', [
                'formTeacher' => $formTeacher->createView(),
                'formCours' => $formCours->createView(),
                'formFormation' => $formFormation->createView(),
                'courses' => $courses,
                'forma' => $forma,
            ]);
        }

        if ($formCours->isSubmitted()) {
            //$teacher = $this->teacher_repository->findByParam($search);
            $allCours = $this->coursRepository->findByTitle($search);

            dump($search, $allCours);

            return $this->render('bdd/index.html.twig', [
                'formTeacher' => $formTeacher->createView(),
                'formCours' => $formCours->createView(),
                'formFormation' => $formFormation->createView(),
                'search' => $search,
                //'teacher' => $teacher,
                'allCours' => $allCours,
            ]);
        }

        return $this->render('bdd/index.html.twig', [
            'formTeacher' => $formTeacher->createView(),
            'formCours' => $formCours->createView(),
            'formFormation' => $formFormation->createView()
        ]);
    }
}

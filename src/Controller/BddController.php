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
        /*$teacher = new Teacher();
        $teacher->setFirstname('Bertrand')
            ->setLastname('Pleven')
            ->setEmail('test@test.fr')
            ->setPhone('0612345678');
        $em = $this->getDoctrine()->getManager();
        $em->persist($teacher);
        $em->flush();*/

        $teacher = $this->teacher_repo->find(3);
        dump($teacher);

        return $this->render('bdd/index.html.twig', [
            'teachers' => $teacher,
        ]);
    }
}

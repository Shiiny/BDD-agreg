<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BddController extends AbstractController
{
    /**
     * @Route("/", name="bdd")
     */
    public function index(TeacherRepository $repository)
    {
        /*$teacher = new Teacher();
        $teacher->setFirstname('Bertrand')
            ->setLastname('Pleven')
            ->setEmail('test@test.fr');
        $em = $this->getDoctrine()->getManager();
        $em->persist($teacher);
        $em->flush();*/

        $teacher = $repository->findAll();
        dump($teacher);

        return $this->render('bdd/index.html.twig', [
            'teachers' => $teacher,
        ]);
    }
}

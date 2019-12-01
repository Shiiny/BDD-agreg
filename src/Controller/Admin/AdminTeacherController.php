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
 * @Route("/admin/teacher")
 */
class AdminTeacherController extends AbstractController
{
    /**
     * @Route("/", name="admin.teacher.index")
     * @param TeacherRepository $teacherRepository
     * @return Response
     */
    public function index(TeacherRepository $teacherRepository):Response
    {
        return $this->render('bdd/admin/teacher/index.html.twig', [
            'teachers' => $teacherRepository->findAll(),
        ]);
    }

    /**
     * @Route("/edit={id}", name="admin.teacher.edit")
     * @param Teacher $teacher
     * @param Request $request
     * @return Response
     */
    public function edit(Teacher $teacher, Request $request):Response
    {
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Enseignant modifié');
            return $this->redirectToRoute('admin.teacher.index');
        }

        return $this->render('bdd/admin/teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="admin.teacher.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request):Response
    {
        $teacher = new Teacher();

        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher);
            $em->flush();
            $this->addFlash('success', 'Enseignant ajouté');
            return $this->redirectToRoute('admin.teacher.index');
        }

        return $this->render('bdd/admin/teacher/new.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete={id}", name="admin.teacher.delete", methods="DELETE")
     * @param Teacher $teacher
     * @param Request $request
     * @return Response
     */
    public function delete(Teacher $teacher, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete' . $teacher->getId(), $request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($teacher);
            $em->flush();
            $this->addFlash('danger', 'Enseignant supprimé');
        }
        return $this->redirectToRoute('admin.teacher.index');
    }

}
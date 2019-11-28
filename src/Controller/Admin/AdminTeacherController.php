<?php


namespace App\Controller\Admin;


use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTeacherController extends AbstractController
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
     * @Route("/admin/teacher", name="admin.teacher.index")
     */
    public function index()
    {
        $teachers = $this->teacher_repo->findAll();
        return $this->render('bdd/admin/teacher/index.html.twig', compact('teachers'));
    }

    /**
     * @Route("/admin/teacher/edit={id}", name="admin.teacher.edit")
     * @param Teacher $teacher
     * @param Request $request
     * @return Response
     */
    public function edit(Teacher $teacher, Request $request)
    {
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Enseignant modifié');
            return $this->redirectToRoute('admin.index');
        }

        return $this->render('bdd/admin/teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/teacher/create", name="admin.teacher.create")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $teacher = new Teacher();

        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher);
            $em->flush();
            $this->addFlash('success', 'Enseignant ajouté');
            return $this->redirectToRoute('admin.index');
        }

        return $this->render('bdd/admin/teacher/create.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/teacher/delete={id}", name="admin.teacher.delete", methods="DELETE")
     * @param Teacher $teacher
     * @param Request $request
     * @return Response
     */
    public function delete(Teacher $teacher, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $teacher->getId(), $request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($teacher);
            $em->flush();
            $this->addFlash('danger', 'Enseignant supprimé');
        }
        return $this->redirectToRoute('admin.index');
    }

}
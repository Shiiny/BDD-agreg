<?php

namespace App\Controller\Admin;

use App\Data\SearchData;
use App\Entity\Cours;
use App\Form\CoursType;
use App\Form\SearchCoursForm;
use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/cours")
 */
class AdminCoursController extends AbstractController
{
    /**
     * @Route("/", name="admin.cours.index")
     * @param CoursRepository $cr
     * @param Request $request
     * @return Response
     */
    public function index(CoursRepository $cr, Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);

        $formCours = $this->createForm(SearchCoursForm::class, $data);

        $formCours->handleRequest($request);

        if ($formCours->isSubmitted()) {

            return $this->render('bdd/admin/cours/index.html.twig', [
                'cours' => $cr->findAllSearch($data),
                'current_menu' => 'cours',
                'formCours' => $formCours->createView(),
                'data' => $data->cours
            ]);
        }

        return $this->render('bdd/admin/cours/index.html.twig', [
            'cours' => $cr->findAllCourses($data),
            'current_menu' => 'cours',
            'formCours' => $formCours->createView()
        ]);
    }

    /**
     * @Route("/new", name="admin.cours.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $cour = new Cours();
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cour);
            $em->flush();
            $this->addFlash('success', 'Cours ajouté');

            return $this->redirectToRoute('admin.cours.index');
        }

        return $this->render('bdd/admin/cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit={id}", name="admin.cours.edit")
     * @param Request $request
     * @param Cours $cour
     * @return Response
     */
    public function edit(Request $request, Cours $cour): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Cours modifié');

            return $this->redirectToRoute('admin.cours.index');
        }

        return $this->render('bdd/admin/cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete={id}", name="admin.cours.delete", methods={"DELETE"})
     * @param Request $request
     * @param Cours $cour
     * @return Response
     */
    public function delete(Request $request, Cours $cour): Response
    {
        if ($this->isCsrfTokenValid('delete' . $cour->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cour);
            $em->flush();
            $this->addFlash('danger', 'Cours supprimé');
        }

        return $this->redirectToRoute('admin.cours.index');
    }
}
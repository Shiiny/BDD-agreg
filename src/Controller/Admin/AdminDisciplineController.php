<?php

namespace App\Controller\Admin;

use App\Entity\Discipline;
use App\Form\DisciplineType;
use App\Repository\DisciplineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/discipline")
 */
class AdminDisciplineController extends AbstractController
{
    /**
     * @Route("/", name="admin.discipline.index")
     * @param DisciplineRepository $disciplineRepository
     * @return Response
     */
    public function index(DisciplineRepository $disciplineRepository): Response
    {
        return $this->render('bdd/admin/discipline/index.html.twig', [
            'disciplines' => $disciplineRepository->findAll(),
            'current_menu' => 'discipline'
        ]);
    }

    /**
     * @Route("/new", name="admin.discipline.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $discipline = new Discipline();
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($discipline);
            $em->flush();
            $this->addFlash('success', 'Discipline ajoutée');

            return $this->redirectToRoute('admin.discipline.index');
        }

        return $this->render('bdd/admin/discipline/new.html.twig', [
            'discipline' => $discipline,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit={id}", name="admin.discipline.edit")
     * @param Request $request
     * @param Discipline $discipline
     * @return Response
     */
    public function edit(Request $request, Discipline $discipline): Response
    {
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Discipline modifiée');

            return $this->redirectToRoute('admin.discipline.index');
        }

        return $this->render('bdd/admin/discipline/edit.html.twig', [
            'discipline' => $discipline,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete={id}", name="admin.discipline.delete", methods={"DELETE"})
     * @param Request $request
     * @param Discipline $discipline
     * @return Response
     */
    public function delete(Request $request, Discipline $discipline): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discipline->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($discipline);
            $em->flush();
            $this->addFlash('danger', 'Discipline supprimée');
        }

        return $this->redirectToRoute('admin.discipline.index');
    }
}

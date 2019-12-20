<?php

namespace App\Controller\Admin;

use App\Entity\Concours;
use App\Form\ConcoursType;
use App\Repository\ConcoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/concours")
 */
class AdminConcoursController extends AbstractController
{
    /**
     * @Route("/", name="admin.concours.index")
     * @param ConcoursRepository $concoursRepository
     * @return Response
     */
    public function index(ConcoursRepository $concoursRepository): Response
    {
        return $this->render('bdd/admin/concours/index.html.twig', [
            'concours' => $concoursRepository->findAll(),
            'current_menu' => 'concours'
        ]);
    }

    /**
     * @Route("/new", name="admin.concours.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $concours = new Concours();
        $form = $this->createForm(ConcoursType::class, $concours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($concours);
            $entityManager->flush();

            $this->addFlash('success', 'Concours crée');
            return $this->redirectToRoute('admin.concours.index');
        }

        return $this->render('bdd/admin/concours/new.html.twig', [
            'concours' => $concours,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit={id}", name="admin.concours.edit")
     * @param Request $request
     * @param Concours $concours
     * @return Response
     */
    public function edit(Request $request, Concours $concours): Response
    {
        $form = $this->createForm(ConcoursType::class, $concours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Concours modifié');
            return $this->redirectToRoute('admin.concours.index');
        }

        return $this->render('bdd/admin/concours/edit.html.twig', [
            'concours' => $concours,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete={id}", name="admin.concours.delete", methods={"DELETE"})
     * @param Request $request
     * @param Concours $concours
     * @return Response
     */
    public function delete(Request $request, Concours $concours): Response
    {
        if ($this->isCsrfTokenValid('delete'.$concours->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($concours);
            $entityManager->flush();
            $this->addFlash('danger', 'Concours supprimé');
        }

        return $this->redirectToRoute('admin.concours.index');
    }
}

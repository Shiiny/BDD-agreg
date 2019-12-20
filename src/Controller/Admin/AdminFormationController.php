<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/formation")
 */
class AdminFormationController extends AbstractController
{
    /**
     * @Route("/", name="admin.formation.index")
     * @param FormationRepository $formationRepository
     * @return Response
     */
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('bdd/admin/formation/index.html.twig', [
            'formations' => $formationRepository->findAll(),
            'current_menu' => 'formation'
        ]);
    }

    /**
     * @Route("/new", name="admin.formation.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            $this->addFlash('success', 'Formation ajoutée');

            return $this->redirectToRoute('admin.formation.index');
        }

        return $this->render('bdd/admin/formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit={id}", name="admin.formation.edit")
     * @param Request $request
     * @param Formation $formation
     * @return Response
     */
    public function edit(Request $request, Formation $formation): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Formation modifiée');

            return $this->redirectToRoute('admin.formation.index');
        }

        return $this->render('bdd/admin/formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete={id}", name="admin.formation.delete", methods={"DELETE"})
     * @param Request $request
     * @param Formation $formation
     * @return Response
     */
    public function delete(Request $request, Formation $formation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($formation);
            $em->flush();
            $this->addFlash('danger', 'Formation supprimée');
        }

        return $this->redirectToRoute('admin.formation.index');
    }
}

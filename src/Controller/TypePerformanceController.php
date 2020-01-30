<?php

namespace App\Controller;

use App\Entity\TypePerformance;
use App\Form\TypePerformanceType;
use App\Repository\TypePerformanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/performance")
 */
class TypePerformanceController extends AbstractController
{
    /**
     * @Route("/", name="type_performance_index", methods={"GET"})
     */
    public function index(TypePerformanceRepository $typePerformanceRepository): Response
    {
        return $this->render('type_performance/index.html.twig', [
            'type_performances' => $typePerformanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_performance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typePerformance = new TypePerformance();
        $form = $this->createForm(TypePerformanceType::class, $typePerformance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typePerformance);
            $entityManager->flush();
            $this->addFlash(
                'success',
                "Un type de performance vient d'etre crée."
            );

            return $this->redirectToRoute('type_performance_index');
        }

        return $this->render('type_performance/new.html.twig', [
            'type_performance' => $typePerformance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_performance_show", methods={"GET"})
     */
    public function show(TypePerformance $typePerformance): Response
    {
        return $this->render('type_performance/show.html.twig', [
            'type_performance' => $typePerformance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_performance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypePerformance $typePerformance): Response
    {
        $form = $this->createForm(TypePerformanceType::class, $typePerformance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                "Un type de performance vient d'etre édité."
            );

            return $this->redirectToRoute('type_performance_index');
        }

        return $this->render('type_performance/edit.html.twig', [
            'type_performance' => $typePerformance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_performance_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypePerformance $typePerformance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typePerformance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typePerformance);
            $entityManager->flush();
            $this->addFlash(
                'danger',
                "Un type de  performance vient d'etre supprimée."
            );
        }

        return $this->redirectToRoute('type_performance_index');
    }
}

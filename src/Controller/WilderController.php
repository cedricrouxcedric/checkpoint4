<?php

namespace App\Controller;

use App\Entity\Wilder;
use App\Form\WilderType;
use App\Repository\WilderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/wilder")
 */
class WilderController extends AbstractController
{
    /**
     * @Route("/", name="wilder_index", methods={"GET"})
     */
    public function index(WilderRepository $wilderRepository,Request $request, PaginatorInterface $paginator)
    { $wilders = $wilderRepository->findAll();

    $wilders = $paginator->paginate(
        $wilders,
        $request->query->getInt('page',1),
        5);

        return $this->render('wilder/index.html.twig', [
            'wilders' => $wilders,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new", name="wilder_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $wilder = new Wilder();
        $form = $this->createForm(WilderType::class, $wilder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wilder);
            $entityManager->flush();
            $this->addFlash(
                'success',
                "Un Wilder vient d'etre ajouté à la liste."
            );

            return $this->redirectToRoute('wilder_index');
        }

        return $this->render('wilder/new.html.twig', [
            'wilder' => $wilder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wilder_show", methods={"GET"})
     */
    public function show(Wilder $wilder): Response
    {
        return $this->render('wilder/show.html.twig', [
            'wilder' => $wilder,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/edit", name="wilder_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Wilder $wilder): Response
    {
        $form = $this->createForm(WilderType::class, $wilder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                "Votre modification a bien été prise en compte."
            );
            return $this->redirectToRoute('wilder_index');

        }


        return $this->render('wilder/edit.html.twig', [
            'wilder' => $wilder,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="wilder_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Wilder $wilder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wilder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wilder);
            $entityManager->flush();
            $this->addFlash(
                'danger',
                "Un Wilder a été supprimé."
            );
        }

        return $this->redirectToRoute('wilder_index');
    }
}

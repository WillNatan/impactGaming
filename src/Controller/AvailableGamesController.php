<?php

namespace App\Controller;

use App\Entity\AvailableGames;
use App\Form\AvailableGamesType;
use App\Repository\AvailableGamesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration/jeux")
 */
class AvailableGamesController extends AbstractController
{
    /**
     * @Route("/", name="available_games_index", methods={"GET"})
     */
    public function index(AvailableGamesRepository $availableGamesRepository): Response
    {
        return $this->render('admin/available_games/index.html.twig', [
            'available_games' => $availableGamesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="available_games_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $availableGame = new AvailableGames();
        $form = $this->createForm(AvailableGamesType::class, $availableGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($availableGame);
            $entityManager->flush();

            return $this->redirectToRoute('available_games_index');
        }

        return $this->render('admin/available_games/new.html.twig', [
            'available_game' => $availableGame,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="available_games_show", methods={"GET"})
     */
    public function show(AvailableGames $availableGame): Response
    {
        return $this->render('admin/available_games/show.html.twig', [
            'available_game' => $availableGame,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="available_games_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AvailableGames $availableGame): Response
    {
        $form = $this->createForm(AvailableGamesType::class, $availableGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('available_games_index');
        }

        return $this->render('admin/available_games/edit.html.twig', [
            'available_game' => $availableGame,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="available_games_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AvailableGames $availableGame): Response
    {
        if ($this->isCsrfTokenValid('delete'.$availableGame->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($availableGame);
            $entityManager->flush();
        }

        return $this->redirectToRoute('available_games_index');
    }
}

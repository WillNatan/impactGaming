<?php

namespace App\Controller;

use App\Entity\EventCategory;
use App\Form\EventCategoryType;
use App\Repository\EventCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration/categories")
 */
class EventCategoryController extends AbstractController
{
    /**
     * @Route("/", name="event_category_index", methods={"GET"})
     */
    public function index(EventCategoryRepository $eventCategoryRepository): Response
    {
        return $this->render('admin/event_category/index.html.twig', [
            'event_categories' => $eventCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/nouveau", name="event_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $eventCategory = new EventCategory();
        $form = $this->createForm(EventCategoryType::class, $eventCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventCategory);
            $entityManager->flush();

            return $this->redirectToRoute('event_category_index');
        }

        return $this->render('admin/event_category/new.html.twig', [
            'event_category' => $eventCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_category_show", methods={"GET"})
     */
    public function show(EventCategory $eventCategory): Response
    {
        return $this->render('admin/event_category/show.html.twig', [
            'event_category' => $eventCategory,
        ]);
    }

    /**
     * @Route("/{id}/modification", name="event_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventCategory $eventCategory): Response
    {
        $form = $this->createForm(EventCategoryType::class, $eventCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_category_index');
        }

        return $this->render('admin/event_category/edit.html.twig', [
            'event_category' => $eventCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EventCategory $eventCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_category_index');
    }
}

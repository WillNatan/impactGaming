<?php

namespace App\Controller;

use App\Entity\Events;
use App\Entity\SocialLinks;
use App\Form\EventsAdminType;
use App\Form\EventsType;
use App\Repository\EventsRepository;
use App\Repository\SocialLinksRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration/evenements")
 */
class EventsController extends AbstractController
{
    /**
     * @Route("/", name="events_index", methods={"GET"})
     */
    public function index(EventsRepository $eventsRepository): Response
    {
        return $this->render('admin/events/index.html.twig', [
            'events' => $eventsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/nouveau", name="events_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Events();
        $form = $this->createForm(EventsAdminType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $replaceSpace = str_replace(" ", "-", $event->getName());
            $replaceComma = str_replace(',', '', $replaceSpace);
            $event->setSlug($replaceComma);
            $event->setUser($this->getUser());

            if (!is_null($form->get('fbUrl')->getData())) {
                $ss = new SocialLinks();
                $ss->setUrl($form->get('fbUrl')->getData())
                    ->setEvent($event)
                    ->setType('facebook')
                    ->setClass('fa-facebook-f');
                $entityManager->persist($ss);
            }
            if (!is_null($form->get('twUrl')->getData())) {
                $ss = new SocialLinks();
                $ss->setUrl($form->get('twUrl')->getData())
                    ->setEvent($event)
                    ->setType('twitter')
                    ->setClass('fa-twitter');
                $entityManager->persist($ss);
            }

            
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('events_index');
        }

        return $this->render('admin/events/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="events_show", methods={"GET"})
     */
    public function show(Events $event): Response
    {
        return $this->render('admin/events/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="events_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Events $event): Response
    {


        $form = $this->createForm(EventsAdminType::class, $event);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            if (count($event->getSocialLinks()) == 0) {
                if (!is_null($form->get('fbUrl')->getData())) {
                    $newLink = new SocialLinks();
                    $newLink->setType('facebook')
                        ->setClass('fa-facebook-f')
                        ->setUrl($form->get('fbUrl')->getData());
                    $this->getDoctrine()->getManager()->persist($newLink);
                    $event->addSocialLink($newLink);
                }

                if (!is_null($form->get('twUrl')->getData())) {
                    $newLink = new SocialLinks();
                    $newLink->setType('twitter')
                        ->setClass('fa-twitter')
                        ->setUrl($form->get('twUrl')->getData());
                    $this->getDoctrine()->getManager()->persist($newLink);
                    $event->addSocialLink($newLink);
                }
            } else if (count($event->getSocialLinks()) == 1) {
                foreach ($event->getSocialLinks() as $link) {
                    if ($link->getType() == 'facebook' && !is_null($form->get('twUrl')->getData())) {
                        $newLink = new SocialLinks();
                        $newLink->setType('twitter')
                            ->setClass('fa-twitter')
                            ->setUrl($form->get('twUrl')->getData());
                        $this->getDoctrine()->getManager()->persist($newLink);
                        $event->addSocialLink($newLink);
                    } else if ($link->getType() == 'twitter' && !is_null($form->get('fbUrl')->getData())) {
                        $newLink = new SocialLinks();
                        $newLink->setType('facebook')
                            ->setClass('fa-facebook-f')
                            ->setUrl($form->get('fbUrl')->getData());
                        $this->getDoctrine()->getManager()->persist($newLink);
                        $event->addSocialLink($newLink);
                    }
                }
            } else {
                foreach ($event->getSocialLinks() as $link) {

                    if ($link->getType() == 'facebook') {
                        if (!is_null($form->get('fbUrl')->getData()) && $link->getUrl() != $form->get('fbUrl')->getData()) {
                            $link->setUrl($form->get('fbUrl')->getData());
                        }
                    } else if ($link->getType() == 'twitter') {
                        if (!is_null($form->get('twUrl')->getData()) && $link->getUrl() != $form->get('twUrl')->getData()) {
                            $link->setUrl($form->get('twUrl')->getData());
                        }
                    }
                }
            }
            if ($event->getName() != $currentEventName) {
                $replaceSpace = str_replace(" ", "-", $event->getName());
                $replaceComma = str_replace(',', '', $replaceSpace);
                $event->setSlug($replaceComma);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_index');
        }

        return $this->render('admin/events/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="events_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Events $event): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events_index');
    }

    /**
     * @Route("/deletelink/{socialid}", name="slink_delete", methods={"DELETE"})
     */
    public function deleteLink(Request $request, $socialid, SocialLinksRepository $socialLinksRepository)
    {
        $link = $socialLinksRepository->find($socialid);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($link);
        $entityManager->flush();


        return new JsonResponse();
    }
}

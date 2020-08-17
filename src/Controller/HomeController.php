<?php

namespace App\Controller;

use App\Entity\Events;
use App\Form\EventsType;
use App\Form\EditUserType;
use App\Repository\EventsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/mes-evenements/nouveau", name="events_business_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $replaceSpace = str_replace(" ", "-", $event->getName());
            $replaceComma = str_replace(',', '', $replaceSpace);
            $event->setSlug($replaceComma);
            $event->setUser($this->getUser());
            
            $entityManager->persist($event);
            
            $entityManager->flush();
            return $this->redirectToRoute('my_events');
        }

        return $this->render('business/addEvent.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("mes-evenements", name="my_events", methods={"GET"})
     */
    public function myEvents(EventsRepository $eventsRepository, PaginatorInterface $paginator, Request $request)
    {
        $pagination = $paginator->paginate(
            $eventsRepository->findBy(['user' => $this->getUser()]), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('home/myEvents.html.twig', [
            'events' => $pagination,
        ]);
    }

    /**
     * @Route("mes-evenements/{slug}", name="my_events_business" , methods={"GET"})
     */
    public function myEventsBusiness(Events $event)
    {
        return $this->render('home/event-single-business.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("mes-evenements/modification/{slug}", name="my_events_business_edit", methods={"GET","POST"})
     */
    public function myEventsBusinessEdit(Events $event, Request $request)
    {
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('my_events_business', ['slug' => $event->getSlug()]);
        }

        return $this->render('business/editEvent.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("mon-compte", name="profile")
     */
    public function profile(EventsRepository $eventsRepository, PaginatorInterface $paginator, Request $request)
    {
        $pagination = $paginator->paginate(
            $eventsRepository->findBy(['user' => $this->getUser()]), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        return $this->render('home/profile.html.twig', [
            'events' => $pagination,
        ]);
    }



    /**
     * @Route("evenements", name="events")
     */
    public function events(EventsRepository $eventsRepository, PaginatorInterface $paginator, Request $request)
    {
        $pagination = $paginator->paginate(
            $eventsRepository->findAllEvents(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('home/events.html.twig', [
            'events' => $pagination,
        ]);
    }

    /**
     * @Route("evenement/{slug}", name="single_event")
     */
    public function single_event(Events $event)
    {
        return $this->render('home/event-single.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("mon-compte/modification", name="editProfile")
     */
    public function editProfile(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $user = $this->getUser();

        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!is_null($form->get('oldPassword')->getData())) {
                //1 - Si l'ancien mot de passe est valide et le nouveau n'est pas nul, attribuer le nouveau mot de passe
                if ($encoder->isPasswordValid($user, $form->get('oldPassword')->getData()) && !is_null($form->get('newPassword')->getData())) {

                    $newPassword = $encoder->encodePassword($this->getUser(), $form->get('newPassword')->getData());
                    $user->setPassword($newPassword);
                    $this->addFlash('successWithPw', 'Votre mot de passe a bien été modifié ainsi que vos informations de profil');
                    $this->getDoctrine()->getManager()->flush();
                    return $this->redirectToRoute('profile');
                }
                //2 - Si l'ancien est valide mais le champ nouveau est nul alors message d'erreur
                else if ($encoder->isPasswordValid($user, $form->get('oldPassword')->getData()) && is_null($form->get('newPassword')->getData())) {
                    $this->addFlash('newPasswordError', "Veuillez entrer un nouveau mot de passe !");
                } else {
                    $this->addFlash('passwordError', "Le mot de passe actuel n'est pas valide !");
                }
            } else {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Vos informations de profil ont bien été modifiés');
                return $this->redirectToRoute('profile');
            }
        }

        return $this->render(
            'home/editProfile.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}

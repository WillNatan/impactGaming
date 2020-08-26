<?php

namespace App\Controller;

use App\Entity\Events;
use App\Form\EventsType;
use App\Form\EditUserType;
use App\Entity\SocialLinks;
use App\Repository\EventsRepository;
use App\Repository\SocialLinksRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
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
    public function index(EventsRepository $eventsRepository)
    {
        return $this->render('home/index.html.twig', ['lastEvent' => $eventsRepository->findOneBy([], ['id' => 'DESC'])]);
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
            $eventsRepository->findByUser($this->getUser()), /* query NOT result */
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
            'event' => $event
        ]);
    }

    /**
     * @Route("mes-evenements/modification/{slug}", name="my_events_business_edit", methods={"GET","POST"})
     */
    public function myEventsBusinessEdit(Events $event, Request $request, SocialLinksRepository $socialLinksRepository)
    {
        $currentEventName = $event->getName();
        $form = $this->createForm(EventsType::class, $event);
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
            $eventsRepository->findByUser($this->getUser()), /* query NOT result */
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

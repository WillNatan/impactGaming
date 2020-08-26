<?php

namespace App\Controller;

use App\Entity\Events;
use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/administration")
     */
class AdminController extends AbstractController
{
    /**
     * @Route("", name="admin_home")
     */
    public function index(EventsRepository $events)
    {
        return $this->render('admin/index.html.twig', [
            'eventCount'=>count($events->findAll()),
            'lastEvent'=>$events->findOneBy([],['id'=>'DESC'])
            ]);
    }
}

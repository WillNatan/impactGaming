<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("mon-compte", name="profile")
     */
    public function profile()
    {
        return $this->render('home/profile.html.twig');
    }
}

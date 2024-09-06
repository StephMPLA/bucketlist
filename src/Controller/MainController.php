<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/',name:'main_home')]
    public function home()
    {
        return $this->render('main/home.html.twig');
    }
    #[Route('/AboutUs', name: 'main_about')]
    public function about()
    {
        dump("about");
        return $this->render('main/about.html.twig');
    }
}
<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WishController extends AbstractController
{
    #[Route('/list')]
    public function list(): Response
    {
        return $this->render('wish/list.html.twig');
    }
    #[Route('/details')]
    public function details(): Response
    {
        return $this->render('wish/details.html.twig');
    }
}

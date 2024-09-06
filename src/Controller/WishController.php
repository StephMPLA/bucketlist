<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class WishController extends AbstractController
{
    /*CREATION D'UN OBJET
    #[Route('/list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        //Crée une instance de mon entité
        $wish = new Wish();
        //Ajoute les propriétés de l'objet
        $wish->setAuthor('Marie Laure');
        $wish->setDescription('Etre capable de developper tout ce que je veux');
        $wish->setTitle('Devenir une pro du dev');
        $wish->setPublished(true);
        $wish->setDateCreated(new \DateTime());
        dump($wish);
        //Save Objet
        $entityManager->persist($wish);
        //Envoi vers la Base de donnée
        $entityManager->flush();

        return $this->render('wish/list.html.twig');
    }*/

    //RECUPERE LA BASE DE DONNEE
    #[Route('/list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->findBy(
            ['isPublished' => 1],    // Filtre : uniquement les éléments publiés (isPublished = 1)
            ['dateCreated' => 'DESC'] // Tri : du plus récent au plus ancien
        );


        return $this->render('wish/list.html.twig',
        ['wish' => $wish]);
    }
    #[Route('/details/{id}', name: 'details')]
    //public function details(int $id, WishRepository $wishRepository): Response
     public function details(Wish $wish): Response
    {
        //$wish = $wishRepository->find($id);

        return $this->render('wish/details.html.twig',['wish' => $wish]);
    }
}

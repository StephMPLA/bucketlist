<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Wish;
use App\Form\ListType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/list', name: 'app_wish_list', methods: ['GET'])]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(
            ['isPublished' => 1],    // Filtre : uniquement les éléments publiés (isPublished = 1)
            ['dateCreated' => 'DESC'] // Tri : du plus récent au plus ancien
        );
        $categoryCounts = $wishRepository->countWishesByCategory();
        return $this->render('wish/list.html.twig',
        ['wishes' => $wishes,
            'categoryCounts' => $categoryCounts]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(ListType::class, $wish);

        $wishForm->handleRequest($request);

        //Si on envoi le formulaire et si il est valid
        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            //Date de creation ne peut etre nul donc crée la date d'aujourdhui
            $wish->setDateCreated(new \DateTime());
            $entityManager->persist($wish);
            $entityManager->flush();

            //Ajout un message
            $this->addFlash('success', 'Serie added successfully');
            //details à besoin d'un id donc lui retourner la valeur
            //Bonne pratique toujours faire une redirection sur le bouton envoyer, ca evite que
            // l'utilisateur avec F5 renvoie toujours le meme formulaire plusieurs fois
            return $this->redirectToRoute('details', ['id' => $wish->getId()]);
            //Aller dans base.html.twig pour afficher ce message
        }
        return $this->render('wish/create.html.twig',['wishCreate' => $wishForm->createView()]);
    }

    #[Route('/details/{id}', name: 'details',methods: ['GET'])]
    //public function details(int $id, WishRepository $wishRepository): Response
     public function details(Wish $wish): Response
    {
        //$wish = $wishRepository->find($id);

        return $this->render('wish/details.html.twig',['wish' => $wish]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\CategorieRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LivreController extends AbstractController
{
    #[Route('/book/{id}', name: 'app_livre_show')]
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/books', name: 'app_livres_index')]
    public function index(LivreRepository $livreRepository, CategorieRepository $categorieRepository): Response
    {
        $livres = $livreRepository->findAll();
        $categories = $categorieRepository->findAll();

        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
            'categories' => $categories,
        ]);
    }
}
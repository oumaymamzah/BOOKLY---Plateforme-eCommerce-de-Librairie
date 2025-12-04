<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategorieController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategorieRepository $categorieRepository, LivreRepository $livreRepository): Response
    {
        $categories = $categorieRepository->findAll();
        $livres = $livreRepository->findAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'livres' => $livres,
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show')]
    public function show(Categorie $categorie, LivreRepository $livreRepository): Response
    {
        $livres = $livreRepository->findBy(['categorie' => $categorie]);

        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            'livres' => $livres,
        ]);
    }
}
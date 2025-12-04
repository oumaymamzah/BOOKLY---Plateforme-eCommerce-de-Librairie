<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\EditeurRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'app_acceuil')]
    public function index(
        CategorieRepository $categorieRepository,
        EditeurRepository $editeurRepository,
        LivreRepository $livreRepository
    ): Response {
        // Récupération des données depuis la base
        $categories = $categorieRepository->findAll();
        $editeurs = $editeurRepository->findAll();
        $livres = $livreRepository->findBy([], ['id' => 'DESC'], 8); // 8 derniers livres

        return $this->render('acceuil/index.html.twig', [
            'categories' => $categories,
            'editeurs' => $editeurs,
            'livres' => $livres,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(LivreRepository $livreRepository, CategorieRepository $categorieRepository): Response
    {
        // Get all books for main display
        $livres = $livreRepository->findAll();

        // Get latest books (assuming we have a dateCreated field, otherwise use ID desc)
        $latestBooks = $livreRepository->findBy([], ['id' => 'DESC'], 6);

        // Get featured books (books with price > 50 as example)
        $featuredBooks = $livreRepository->findBy(['prixUnitaire' => '>50'], [], 6);

        // Get best selling books (books with lowest stock as example of popularity)
        $bestSellingBooks = $livreRepository->findBy([], ['prixUnitaire' => 'ASC'], 6);

        // Get all categories
        $categories = $categorieRepository->findAll();

        // Get featured categories (first 4 categories)
        $featuredCategories = array_slice($categories, 0, 4);

        return $this->render('home/index.html.twig', [
            'livres' => $livres,
            'latestBooks' => $latestBooks,
            'featuredBooks' => $featuredBooks,
            'bestSellingBooks' => $bestSellingBooks,
            'categories' => $categories,
            'featuredCategories' => $featuredCategories,
        ]);
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request, LivreRepository $livreRepository, CategorieRepository $categorieRepository): Response
    {
        $query = $request->query->get('s', '');
        $livres = [];

        if (!empty($query)) {
            $livres = $livreRepository->createQueryBuilder('l')
                ->leftJoin('l.auteurs', 'a')
                ->where('l.titre LIKE :query')
                ->orWhere('a.nom LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();
        }

        $categories = $categorieRepository->findAll();

        return $this->render('search/index.html.twig', [
            'query' => $query,
            'livres' => $livres,
            'categories' => $categories,
        ]);
    }
}
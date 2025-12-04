<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(LivreRepository $livreRepository, CategorieRepository $categorieRepository, RequestStack $requestStack): Response
    {
        $user = $this->getUser();
        $session = $requestStack->getSession();

        // Get cart and wishlist data
        $cart = $session->get('cart', []);
        $wishlist = $session->get('wishlist', []);

        // Calculate cart statistics
        $cartItems = [];
        $cartTotal = 0;
        $booksInCart = 0;

        foreach ($cart as $livreId => $quantity) {
            $livre = $livreRepository->find($livreId);
            if ($livre) {
                $cartItems[] = $livre;
                $cartTotal += $livre->getPrixUnitaire() * $quantity;
                $booksInCart += $quantity;
            }
        }

        // Get wishlist items
        $wishlistItems = [];
        foreach ($wishlist as $livreId) {
            $livre = $livreRepository->find($livreId);
            if ($livre) {
                $wishlistItems[] = $livre;
            }
        }

        // Calculate account age
        $accountAge = 0;
        if ($user && $user->getCreatedAt()) {
            $now = new \DateTime();
            $created = $user->getCreatedAt();
            $interval = $now->diff($created);
            $accountAge = $interval->days;
        }

        // Category distribution (simplified - based on wishlist/cart items)
        $categories = $categorieRepository->findAll();
        $categoryLabels = [];
        $categoryData = [];

        foreach ($categories as $category) {
            $categoryLabels[] = $category->getNom();
            // Count books in this category from cart/wishlist
            $count = 0;
            foreach (array_merge($cartItems, $wishlistItems) as $item) {
                if ($item->getCategorie() && $item->getCategorie()->getId() === $category->getId()) {
                    $count++;
                }
            }
            $categoryData[] = $count;
        }

        // Activity data (simplified - last 7 days)
        $activityLabels = [];
        $activityData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = new \DateTime("-{$i} days");
            $activityLabels[] = $date->format('M j');
            // Simplified: random activity data (in real app, this would come from database)
            $activityData[] = rand(0, 5);
        }

        $stats = [
            'books_in_cart' => $booksInCart,
            'wishlist_count' => count($wishlistItems),
            'cart_total' => $cartTotal,
            'account_age' => $accountAge,
            'category_labels' => $categoryLabels,
            'category_data' => $categoryData,
            'activity_labels' => $activityLabels,
            'activity_data' => $activityData,
            'cart_items' => array_slice($cartItems, 0, 4), // Show first 4 items
            'wishlist_items' => array_slice($wishlistItems, 0, 4), // Show first 4 items
        ];

        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }
}
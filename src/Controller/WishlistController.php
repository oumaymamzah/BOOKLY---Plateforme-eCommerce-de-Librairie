<?php

namespace App\Controller;

use App\Service\WishlistService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WishlistController extends AbstractController
{
    #[Route('/wishlist/add/{id}', name: 'app_wishlist_add')]
    public function add(int $id, WishlistService $wishlistService): Response
    {
        $wishlistService->addToWishlist($id);

        $this->addFlash('success', 'Book added to wishlist!');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/wishlist/remove/{id}', name: 'app_wishlist_remove')]
    public function remove(int $id, WishlistService $wishlistService): Response
    {
        $wishlistService->removeFromWishlist($id);

        $this->addFlash('success', 'Book removed from wishlist!');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/wishlist', name: 'app_wishlist')]
    public function index(WishlistService $wishlistService): Response
    {
        $wishlistItems = $wishlistService->getWishlistItems();

        return $this->render('wishlist/index.html.twig', [
            'wishlistItems' => $wishlistItems,
        ]);
    }
}
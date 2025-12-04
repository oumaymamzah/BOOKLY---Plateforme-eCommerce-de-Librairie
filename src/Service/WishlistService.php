<?php

namespace App\Service;

use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class WishlistService
{
    private $requestStack;
    private $livreRepository;

    public function __construct(RequestStack $requestStack, LivreRepository $livreRepository)
    {
        $this->requestStack = $requestStack;
        $this->livreRepository = $livreRepository;
    }

    public function getWishlist(): array
    {
        $session = $this->requestStack->getSession();
        return $session->get('wishlist', []);
    }

    public function addToWishlist(int $livreId): void
    {
        $session = $this->requestStack->getSession();
        $wishlist = $session->get('wishlist', []);

        if (!in_array($livreId, $wishlist)) {
            $wishlist[] = $livreId;
        }

        $session->set('wishlist', $wishlist);
    }

    public function removeFromWishlist(int $livreId): void
    {
        $session = $this->requestStack->getSession();
        $wishlist = $session->get('wishlist', []);

        $key = array_search($livreId, $wishlist);
        if ($key !== false) {
            unset($wishlist[$key]);
            $wishlist = array_values($wishlist); // Reindex array
        }

        $session->set('wishlist', $wishlist);
    }

    public function isInWishlist(int $livreId): bool
    {
        $wishlist = $this->getWishlist();
        return in_array($livreId, $wishlist);
    }

    public function getWishlistItems(): array
    {
        $wishlist = $this->getWishlist();
        $items = [];

        foreach ($wishlist as $livreId) {
            $livre = $this->livreRepository->find($livreId);
            if ($livre) {
                $items[] = $livre;
            }
        }

        return $items;
    }

    public function getItemCount(): int
    {
        return count($this->getWishlist());
    }

    public function clearWishlist(): void
    {
        $session = $this->requestStack->getSession();
        $session->remove('wishlist');
    }
}
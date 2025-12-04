<?php

namespace App\Service;

use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $requestStack;
    private $livreRepository;

    public function __construct(RequestStack $requestStack, LivreRepository $livreRepository)
    {
        $this->requestStack = $requestStack;
        $this->livreRepository = $livreRepository;
    }

    public function getCart(): array
    {
        $session = $this->requestStack->getSession();
        return $session->get('cart', []);
    }

    public function addToCart(int $livreId, int $quantity = 1): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if (isset($cart[$livreId])) {
            $cart[$livreId] += $quantity;
        } else {
            $cart[$livreId] = $quantity;
        }

        $session->set('cart', $cart);
    }

    public function removeFromCart(int $livreId): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if (isset($cart[$livreId])) {
            unset($cart[$livreId]);
        }

        $session->set('cart', $cart);
    }

    public function updateQuantity(int $livreId, int $quantity): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if ($quantity <= 0) {
            unset($cart[$livreId]);
        } else {
            $cart[$livreId] = $quantity;
        }

        $session->set('cart', $cart);
    }

    public function getCartItems(): array
    {
        $cart = $this->getCart();
        $items = [];

        foreach ($cart as $livreId => $quantity) {
            $livre = $this->livreRepository->find($livreId);
            if ($livre) {
                $items[] = [
                    'livre' => $livre,
                    'quantity' => $quantity,
                    'total' => $livre->getPrixUnitaire() * $quantity,
                ];
            }
        }

        return $items;
    }

    public function getTotal(): float
    {
        $items = $this->getCartItems();
        $total = 0;

        foreach ($items as $item) {
            $total += $item['total'];
        }

        return $total;
    }

    public function getItemCount(): int
    {
        $cart = $this->getCart();
        return array_sum($cart);
    }

    public function clearCart(): void
    {
        $session = $this->requestStack->getSession();
        $session->remove('cart');
    }
}
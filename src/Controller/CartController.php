<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        $items = $this->cartService->getCartItems();
        $total = $this->cartService->getTotal();

        return $this->render('cart/index.html.twig', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
    public function add(int $id, Request $request): Response
    {
        $quantity = $request->request->getInt('quantity', 1);
        $this->cartService->addToCart($id, $quantity);

        $this->addFlash('success', 'Item added to cart.');

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove(int $id): Response
    {
        $this->cartService->removeFromCart($id);

        $this->addFlash('success', 'Item removed from cart.');

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/update/{id}', name: 'app_cart_update', methods: ['POST'])]
    public function update(int $id, Request $request): Response
    {
        $quantity = $request->request->getInt('quantity', 1);
        $this->cartService->updateQuantity($id, $quantity);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/clear', name: 'app_cart_clear')]
    public function clear(): Response
    {
        $this->cartService->clearCart();

        $this->addFlash('success', 'Cart cleared.');

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/checkout', name: 'app_cart_checkout', methods: ['POST'])]
    public function checkout(Request $request): Response
    {
        // Simulate payment processing
        // In real app, integrate with payment gateway

        $this->cartService->clearCart();
        $this->addFlash('order_success', 'Votre commande a été passée avec succès ! Vous pouvez accéder à votre compte email.');

        return $this->redirectToRoute('app_cart');
    }
}
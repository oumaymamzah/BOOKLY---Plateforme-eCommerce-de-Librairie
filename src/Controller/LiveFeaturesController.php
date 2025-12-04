<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LiveFeaturesController extends AbstractController
{
    #[Route('/live-features', name: 'app_live_features')]
    public function index(): Response
    {
        // For now, static content
        return $this->render('live_features/index.html.twig');
    }
}
<?php

namespace App\Controller;

use App\Repository\EditeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditeurController extends AbstractController
{
    #[Route('/editors', name: 'app_editors')]
    public function index(EditeurRepository $editeurRepository): Response
    {
        $editeurs = $editeurRepository->findAll();

        return $this->render('editeur/index.html.twig', [
            'editeurs' => $editeurs,
        ]);
    }
}
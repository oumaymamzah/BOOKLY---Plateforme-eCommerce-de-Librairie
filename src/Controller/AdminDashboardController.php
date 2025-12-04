<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Editeur;
use App\Entity\Categorie;
use App\Entity\User;
use App\Entity\Ouvrier;
use App\Repository\LivreRepository;
use App\Repository\AuteurRepository;
use App\Repository\EditeurRepository;
use App\Repository\CategorieRepository;
use App\Repository\UserRepository;
use App\Repository\OuvrierRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class AdminDashboardController extends AbstractDashboardController
{
    public function __construct(
        private LivreRepository $livreRepository,
        private UserRepository $userRepository,
        private CategorieRepository $categorieRepository,
        private AuteurRepository $auteurRepository,
        private EditeurRepository $editeurRepository,
        private OuvrierRepository $ouvrierRepository
    ) {}

    public function index(): Response
    {
        // Get statistics using repositories
        $livresCount = $this->livreRepository->count([]);
        $usersCount = $this->userRepository->count([]);
        $categoriesCount = $this->categorieRepository->count([]);
        $auteursCount = $this->auteurRepository->count([]);
        $editeursCount = $this->editeurRepository->count([]);
        $ouvriersCount = $this->ouvrierRepository->count([]);

        // Calculate total book value
        $livres = $this->livreRepository->findAll();
        $totalValue = 0;
        foreach ($livres as $livre) {
            $totalValue += $livre->getPrixUnitaire() * $livre->getQte();
        }

        return $this->render('admin/index.html.twig', [
            'stats' => [
                'livres' => $livresCount,
                'users' => $usersCount,
                'categories' => $categoriesCount,
                'auteurs' => $auteursCount,
                'editeurs' => $editeursCount,
                'ouvriers' => $ouvriersCount,
                'total_value' => $totalValue,
            ]
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Médiathèque');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        
        yield MenuItem::section('Gestion');

        yield MenuItem::linkToCrud('Livres', 'fa fa-book', Livre::class);
        yield MenuItem::linkToCrud('Auteurs', 'fa fa-user', Auteur::class);
        yield MenuItem::linkToCrud('Éditeurs', 'fa fa-building', Editeur::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-tags', Categorie::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Ouvriers', 'fa fa-user-tie', Ouvrier::class);
    }
}
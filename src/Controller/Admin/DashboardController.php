<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', []);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Blog');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fas fa-home');

        // Configuration de l'entité Article
        yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Article::class);

        // Configuration de l'entité Category
        yield MenuItem::linkToCrud('Categories', 'fas fa-folder', Category::class);

        // Configuration de l'entité User
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);

        // Configuration de l'entité Comment
        yield MenuItem::linkToCrud('Comments', 'fas fa-comments', Comment::class);


        // yield MenuItem::section('Moderation');
        // yield MenuItem::linkToCrud('Approve Comments', 'fas fa-check', Comment::class)
        //     ->setAction('approve')
        //     ->setEntityId('id') // Assure-toi que 'id' est le nom de l'identifiant dans ton entité Comment
        //     ->setController(CommentCrudController::class);
    }
}

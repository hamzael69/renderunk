<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Sport;
use App\Entity\Sportproduct;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard; // Ajoute cet import

#[AdminDashboard(routeName: 'admin', routePath: '/admin')] // Utilise AdminDashboard au lieu de AsDashboard
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Dashboard');
    }

    public function configureMenuItems(): iterable
    {
       
        yield MenuItem::linkToCrud('Catégories de sports', 'fas fa-running', Sport::class);
        yield MenuItem::linkToCrud('Catégories de goodies', 'fas fa-list', Category::class);
        yield MenuItem::linkToUrl('Tenues de sport', 'fas fa-link', $this->generateUrl('sportproduct_index'));
        yield MenuItem::linkToRoute('Goodies', 'fas fa-link', 'categoryproduct_index');
        
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Sport;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class SportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sport::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // Afficher l'ID seulement dans la liste (index) ne crée aucun conflit avec la base de données.
            // Cela empêche juste l'utilisateur de modifier l'ID depuis l'interface admin.
            IdField::new('idSport', 'ID')->onlyOnIndex(),
            TextField::new('name', 'Nom'),
            AssociationField::new('sportproducts', 'Produits liés')
                ->onlyOnDetail()
                ->setTemplatePath('admin/fields/sportproducts_list.html.twig'),
            CollectionField::new('sportproducts', 'Sportproducts liés')
                ->onlyOnDetail()
                ->setTemplatePath('admin/fields/sportproducts_list.html.twig'),
        ];
    }
}

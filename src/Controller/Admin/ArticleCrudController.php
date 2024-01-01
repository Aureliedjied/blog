<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('title', 'Titre'),
            TextField::new('Slug', 'Slug')->hideOnForm(),
            TextareaField::new('content', 'contenu'),
            DateField::new('created_at', 'créé le')->hideOnForm(),
            TextField::new('imageFile', 'Image')->setFormType(VichImageType::class)->onlyWhenCreating(),
            ImageField::new('file', 'Image')->setBasePath('/uploads/articles')->onlyOnIndex(),
            SlugField::new('slug')->setTargetFieldName('imageFile')->hideOnForm(),
            AssociationField::new('category', 'categorie')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['created_at' => 'DESC']);
    }
}

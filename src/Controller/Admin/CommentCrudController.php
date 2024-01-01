<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('author', 'Auteur')
                ->formatValue(function ($value, $entity) {
                    // affichage de l'auteur en concaténant le nom et le prénom
                    return $entity->getAuthor()->getFirstname() . ' ' . $entity->getAuthor()->getLastname();
                })
                ->setFormTypeOption('disabled', true), // Désactiver l'édition dans le formulaire
            TextEditorField::new('content', 'Message'),
            AssociationField::new('article', 'Article')
                ->formatValue(function ($value, $entity) {
                    // affichage du titre de l'article
                    return $entity->getArticle()->getTitle();
                }),
            BooleanField::new('isApproved', 'Approuvé/Désapprouvé')

        ];
    }
}

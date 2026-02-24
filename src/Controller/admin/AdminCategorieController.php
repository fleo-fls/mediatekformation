<?php

namespace App\Controller\admin;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categorie;
use App\Form\CategorieType;

class AdminCategorieController extends AbstractController {
    
    #[Route('/admin/categorie', name: 'admin.categorie')]
    public function index(Request $request, CategorieRepository $repo, EntityManagerInterface $em): Response
    {
        $nouvelleCategorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $nouvelleCategorie);
        $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        
        $em->persist($nouvelleCategorie);
        $em->flush();
        return $this->redirectToRoute('admin.categorie');
    }

    return $this->render('admin/admin.categorie.edit.html.twig', [
        'categories' => $repo->findAll(),
        'form' => $form->createView(),
    ]);
    }

    #[Route('/admin/categorie/supprimer/{id}', name: 'admin.categorie.supprimer')]
    public function delete(Categorie $categorie, EntityManagerInterface $em): Response
    {
    if ($categorie->getFormations()->count() > 0) {
        $this->addFlash('danger', 'Impossible de supprimer : cette catégorie est liée à des formations.');
    } else {
        $em->remove($categorie);
        $em->flush();
        $this->addFlash('success', 'Catégorie supprimée.');
    }

    return $this->redirectToRoute('admin.categorie');
    }
    
    
}
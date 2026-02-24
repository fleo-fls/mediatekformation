<?php

namespace App\Controller\admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFormationController extends AbstractController {

    private $formationRepository;
    private $categorieRepository;

    public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * Page principale Back office
     */
    #[Route('/admin/formation', name: 'admin.formations', methods: ['GET'])]
    public function index(): Response {
        return $this->render("admin/admin.formation.html.twig", [
            'formations' => $this->formationRepository->findAll(),
            'categories' => $this->categorieRepository->findAll()
        ]);
    }

    /**
     * Gestion des tris 
     */
    #[Route('/admin/formations/tri/{champ}/{ordre}/{table}', name: 'admin.formations.sort')]
    public function sort($champ, $ordre, $table=""): Response {
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.formation.html.twig", [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    /**
     * Gestion des recherches
     */
    #[Route('/admin/formations/recherche/{champ}/{table}', name: 'admin.formations.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response {
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.formation.html.twig", [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }

    /**
     * Suppression d'une formation
     */
    #[Route('/admin/formation/suppr/{id}', name: 'admin.formation.suppr')]
    public function suppr(Formation $formation): Response {
        $this->formationRepository->remove($formation);
        $this->addFlash('success', 'La formation a été supprimée avec succès.');
        return $this->redirectToRoute('admin.formations');
    }

    /**
     * Ajout et Modification (Formulaire unique)
     */
    #[Route('/admin/formation/edit/{id}', name: 'admin.formation.edit')]
    #[Route('/admin/formation/ajout', name: 'admin.formation.ajout')]
    public function edit(Request $request, Formation $formation = null): Response {
        if (!$formation) {
            $formation = new Formation();
            $formation->setPublishedAt(new \DateTime()); 
        }

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->formationRepository->add($formation); 
            $this->addFlash('success', 'La formation a été enregistrée.');
            return $this->redirectToRoute('admin.formations');
        }

        return $this->render("admin/admin.formation.edit.html.twig", [
            'formation' => $formation,
            'form' => $form->createView(),
            'isEdition' => $formation->getId() !== null
        ]);
    }
    #[Route('/setup-admin', name: 'setup_admin')]
    public function setupAdmin(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        // On vérifie si l'admin existe déjà pour éviter les doublons
        $user = new User();
        $user->setEmail('admin@mediatek.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($passwordHasher->hashPassword($user, 'votre_mdp_ici'));

        $em->persist($user);
        $em->flush();

        return new Response("Administrateur créé avec succès !");
    }
}
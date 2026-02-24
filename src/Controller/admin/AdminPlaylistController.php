<?php

namespace App\Controller\admin;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\PlaylistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPlaylistController extends AbstractController
{
    public function __construct(
        private PlaylistRepository $playlistRepository,
        private CategorieRepository $categorieRepository,
        private EntityManagerInterface $em,
    ) {}

    #[Route('/admin/playlists', name: 'admin.playlist', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/admin.playlist.html.twig', [
            'playlists' => $this->playlistRepository->findAll(),
            'categories' => $this->categorieRepository->findAll(),
        ]);
    }

   
    #[Route('/admin/playlists/add', name: 'admin.playlists.add', methods: ['GET', 'POST'])]
    public function add(Request $request): Response
    {
        $playlist = new Playlist();
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($playlist);
            $this->em->flush();
            return $this->redirectToRoute('admin.playlist');
        }

        return $this->render('admin/admin.playlist.edit.html.twig', [
            'form' => $form->createView(),
            'playlist' => $playlist,
            'isEdition' => $playlist->getId() !== null,
        ]);
    }

    // Suppression (POST conseillé)
    #[Route('/admin/playlists/remove/{id}', name: 'admin.playlists.remove', methods: ['POST'])]
    public function remove(Request $request, Playlist $playlist): Response
    {
        if ($this->isCsrfTokenValid('delete_playlist_'.$playlist->getId(), $request->request->get('_token'))) {
            $this->em->remove($playlist);
            $this->em->flush();
        }
        return $this->redirectToRoute('admin.playlist');
    }
     /**
     * Ajout et Modification (Formulaire unique)
     */
    #[Route('/admin/playlists/edit/{id}', name: 'admin.playlists.edit')]
    public function edit(Request $request, Playlist $playlist = null): Response {
        if (!$playlist) {
            $playlist = new Playlist();
            $playlist->setPublishedAt(new \DateTime()); 
        }

        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->playlistRepository->add($playlist); 
            $this->addFlash('success', 'La playlist a été enregistrée.');
            return $this->redirectToRoute('admin.playlists');
        }

        return $this->render("admin/admin.playlist.edit.html.twig", [
            'playlist' => $playlist,
            'form' => $form->createView(),
            'isEdition' => $playlist->getId() !== null
        ]);
    }
}
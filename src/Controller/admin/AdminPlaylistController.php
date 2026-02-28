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
    /**
     * 
     * @param PlaylistRepository $playlistRepository
     * @param CategorieRepository $categorieRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(
        private PlaylistRepository $playlistRepository,
        private CategorieRepository $categorieRepository,
        private EntityManagerInterface $em,
    ) {}
    /**
     * 
     * @return Response
     */
    #[Route('/admin/playlists', name: 'admin.playlist', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/admin.playlist.html.twig', [
            'playlists' => $this->playlistRepository->findAll(),
            'categories' => $this->categorieRepository->findAll(),
        ]);
    }

    /**
     * ajout de playlist
     * @param Request $request
     * @return Response
     */
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

    /**
     * suppression de playlist
     * @param Request $request
     * @param Playlist $playlist
     * @return Response
     */
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
     * Modification de playlist 
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
    #[Route('/admin/playlists/tri/{champ}/{ordre}', name: 'admin.playlists.sort')]
    public function sort($champ, $ordre): Response{
        if ($champ==="name"){
                $playlists = $this->playlistRepository->findAllOrderByName($ordre);
        }elseif ($champ==="nbformations"){
            $playlists = $this->playlistRepository->findAllOrderByNbFormation($ordre);
        }else{
            throw $this->createNotFoundException('Champ de tri invalide.');
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.playlist.html.twig", [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }     
    #[Route('/admin/playlists/recherche/{champ}/{table}', name: 'admin.playlists.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response {
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.playlist.html.twig", [
            'playlists' => $playlists,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table,
            'champ' => $champ
        ]);
    }
}
<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_home', methods: ['GET'])]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('admin.formations'); // ou admin.playlist, etc.
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecureFileController extends AbstractController
{
    #[Route('/secure-file/{fileType}/{filename}', name: 'app_secure_file')]
    public function index(string $fileType, string $filename, Request $request): Response
    {
        $filePath = $this->getParameter('kernel.project_dir').'/var/uploads'.'/'.$fileType.'/'.$filename;
        // dd($filePath);
        if(!file_exists($filePath)){
            throw $this->createNotFoundException('Fichier introuvable x_x');
        }
        $user = $this->getUser();
        // dd($user);
        if(!$user && !$this->isGranted('ROLE_ADVISOR') && !$this->isGranted('ROLE_VALIDATOR')){
            throw $this->createAccessDeniedException('Vous n\'avez pas l\'autorisation d\'accéder à ce fichier.');
        }

        $response = new Response(file_get_contents($filePath));
        $response->headers->set('Content-Type', mime_content_type($filePath));
        return $response;
    }
}

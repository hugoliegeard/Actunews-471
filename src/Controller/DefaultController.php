<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * Page / Action Accueil
     * @Route("/", name="default_index")
     */
    public function index()
    {
        return new Response("<h1>Page Accueil</h1>");
    }
}
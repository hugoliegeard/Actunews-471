<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * Page / Action Accueil
     * ex. http://localhost:8000/
     * @Route("/", name="default_index", methods={"GET"})
     */
    public function index()
    {
        # return new Response("<h1>Page Accueil</h1>");

        # Grâce à render, je vais pouvoir effectuer le rendu d'une vue.
        return $this->render("default/index.html.twig");
    }

    /**
     * Page / Action Catégorie
     * Afficher les articles d'une catégorie
     * ex. http://localhost:8000/politique, http://localhost:8000/economie, ...
     * @Route("/{alias}", name="default_category", methods={"GET"})
     */
    public function category($alias)
    {
        return $this->render("default/category.html.twig");
    }

    /**
     * Page / Action Article
     * Afficher le contenu d'un article
     * ex. http://localhost:8000/politique/covid-19-une-troisieme-vague_1.html
     * @Route("/{category}/{alias}_{id}.html", name="default_post", methods={"GET"})
     */
    public function post($id, $category, $alias)
    {
        return $this->render("default/post.html.twig");
    }
}
<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Gestion des Articles du site.
 * @Route("/dashboard/post")
 */
class PostController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * Créer un Article
     * @Route("/create", name="post_create", methods={"GET|POST"})
     * ex. http://localhost:8000/dashboard/post/create
     */
    public function create()
    {
        # Création d'un nouvel article VIDE.
        $post = new Post();
        $post->setCreatedAt(new \DateTime());
        # TODO User

        # Création du Formulaire
        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Choisissez une catégorie'
            ])
            ->add('content', TextareaType::class, [
                'label' => "Contenu de l'article"
            ])
            ->add('image', FileType::class, [
                'label' => "Illustration",
                'attr' => [
                    'class' => 'dropify'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Publier cet Article'
            ])
            ->getForm()
        ;

        # Afficher le formulaire dans la vue
        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Mettre à jour un Article
     * @Route("/{id}/update", name="post_update", methods={"GET|POST"})
     * ex. http://localhost:8000/dashboard/post/1/update
     */
    public function update()
    {
        # TODO à faire.
    }

    /**
     * Supprimer un Article
     * @Route("/{id}/delete", name="post_delete", methods={"GET"})
     * ex. http://localhost:8000/dashboard/post/1/delete
     */
    public function delete()
    {
        # TODO à faire.
    }
}

<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
     * @param Request $request : Contient la requète de l'utilisateur et ses données.
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function create(Request $request, SluggerInterface $slugger)
    {
        # Création d'un nouvel article VIDE.
        $post = new Post();
        $post->setCreatedAt(new \DateTime());

        # FIXME : Remplacer par l'utilisateur connecté
        $post->setUser(
          $this->getDoctrine()->getRepository(User::class)->find(1)
        );

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
            ->getForm();

        # Permet au formulaire de récupérer les données dans la Request.
        $form->handleRequest($request);

        # Si le formulaire a été soumis : équivalent à : if isset $_POST
        if ($form->isSubmitted() && $form->isValid()) {

            # Upload de l'image
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {

                # Générer le nom de l'image | Sécurisation du nom de l'image
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                # Upload de l'image
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    # TODO Notification, upload impossible.
                }

                # /!\ Permet de définir le nouveau nom de l'image dans la BDD /!\
                $post->setImage($newFilename);
            }

            # Génération de l'alias
            $post->setAlias(
                $slugger->slug(
                    $post->getTitle()
                )
            );

            # Sauvegarde dans la BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            # TODO : Notification Flash / Confirmation

            # Redirection vers l'article
            return $this->redirectToRoute('default_post', [
               'category' => $post->getCategory()->getAlias(),
               'alias' => $post->getAlias(),
               'id' => $post->getId(),
            ]);
        }

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

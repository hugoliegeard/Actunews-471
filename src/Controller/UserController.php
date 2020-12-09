<?php


namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * Inscrire un  Utilisateur
     * @Route("/register", name="user_register", methods={"GET|POST"})
     * ex. http://localhost:8000/user/register
     */
    public function register()
    {
        # Création d'un User
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $user->setCreatedAt(new \DateTime());

        # Création du Formulaire
        $form = $this->createFormBuilder($user)
            ->add('firstname', TextType::class, [
                'label' => 'Votre Prénom.'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre Nom.'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre Email.'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Votre mot de passe.'
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Je m'abonne !"
            ])
            ->getForm();

        # Affichage du formulaire dans la vue
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
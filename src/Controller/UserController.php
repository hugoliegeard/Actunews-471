<?php


namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * Inscrire un  Utilisateur
     * @Route("/register", name="user_register", methods={"GET|POST"})
     * ex. http://localhost:8000/user/register
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
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

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            # Encodage du mot de passe
            $user->setPassword(
                $encoder->encodePassword(
                    $user, $user->getPassword()
                )
            );

            # Sauvegarde dans la BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            # TODO : Notification Flash / Confirmation

            # Redirection vers l'accueil
            return $this->redirectToRoute('default_index');

        }

        # Affichage du formulaire dans la vue
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
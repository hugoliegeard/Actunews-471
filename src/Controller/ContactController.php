<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * Page / Action Contact
     * http://localhost:8000/page/contact
     * @Route("/page/contact", name="contact_contact", methods={"GET|POST"})
     */
    public function contact()
    {
        $form = $this->createFormBuilder()
            ->add('fullname', TextType::class)
            ->add('email', EmailType::class)
            ->add('phone', TelType::class)
            ->add('subject', TextType::class)
            ->add('message', TextareaType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView()
        ]);

    }
}

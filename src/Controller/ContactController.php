<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController
{
    /**
     * Page / Action Contact
     * http://localhost:8000/page/contact
     * @Route("/page/contact", name="contact_contact", methods={"GET"})
     */
    public function contact()
    {
        return new Response("<h1>Page Contact</h1>");
    }
}

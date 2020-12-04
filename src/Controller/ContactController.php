<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class ContactController
{
    /**
     * Page / Action Contact
     * @return Response
     */
    public function contact(): Response
    {
        return new Response("<h1>Page Contact</h1>");
    }
}

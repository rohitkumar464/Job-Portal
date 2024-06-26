<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="error_404")
     */
    public function index(): Response
    {
        return $this->render('error/index.html.twig', [
            'controller_name' => '404_error',
        ]);
    }
    

}

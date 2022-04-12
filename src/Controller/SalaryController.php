<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalaryController extends AbstractController
{
    #[Route('/salary', name: 'app_salary')]
    public function index(): Response
    {
        return $this->render('salary/index.html.twig', [
            'controller_name' => 'SalaryController',
        ]);
    }
}

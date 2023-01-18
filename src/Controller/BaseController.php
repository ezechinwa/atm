<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{

    #[Route('/', name: 'homepage')]
    public function homepage() : Response
        //JsonResponse
    {
         return $this->redirect('/app/login');

    }



    #[Route('/app/{vueroutes}', name: 'webapp_base')]
    public function index() : Response
    //JsonResponse
    {
        return $this->render('base.html.twig');
    }


    #[Route('/app/dashboard/{vueroutes}', name: 'webapp_base_logged')]
    public function logged() : Response
        //JsonResponse
    {
        return $this->render('base.html.twig');
    }
    // {vueRouting}
}

<?php

namespace App\Controller;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController{

 

    function index(PropertyRepository $repository):Response
    {
         $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig',
        ['properties' => $properties]
    );
    }
}
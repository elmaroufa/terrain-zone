<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Repository\PropertyRepository;
use  Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PropertySearchType;

class PropertyController extends AbstractController {

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface;
     */
    private $em;

    public function __construct(PropertyRepository $repository,EntityManagerInterface $em){
        $this->repository = $repository;
    }
 
    /**
     * @Route("/bien",name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator,Request $request):Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page',1),
            9
        );
       // $properties = $this->repository->findAllVisible();
        return $this->render('pages/property.html.twig',[
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }
 /**
     * @Route("/bien/{slug}-{id}",name="property.show", requirements={"slug":"[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property,string $slug):Response
    {
        if($property->getSlug() !== $slug)
         {
            return  $this->redirectToRoute('property.show',[
                'id' => $property->getId(),
                'slug' => $property->getSlug()
             ],301);
         }
        //$property = $this->repository->find($id);
        return $this->render("pages/show.html.twig",[
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }

}
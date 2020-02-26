<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use  Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function index():Response
    {
       /* $property = new Property();
        $property->setTitle("Maison de boukar")
                 ->setPrice(3000000)
                 ->setRooms(4)
                 ->setBedrooms(3)
                 ->setDescription("Ma description")
                 ->setSurface(60)
                 ->setFloor(4)
                 ->setHeat(1)
                 ->setCity('GUIDER')
                 ->setAddress('QUARTIER SARA')
                 ->setPostalCode("12234243");
                 $em = $this->getDoctrine()->getManager();
                 $em->persist($property);
                 $em->flush(); */
       // $properties = $this->repository->findAllVisible();
        //dump($properties);

        return $this->render('pages/property.html.twig',[
            'current_menu' => 'properties'
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
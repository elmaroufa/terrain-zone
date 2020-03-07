<?php
namespace App\Controller\Admin;

use App\Repository\PropertyRepository;
use  Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Property;
use App\Form\PropertyType;

class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $reporsitory;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    function __construct(PropertyRepository $reporsitory,EntityManagerInterface $em)
    {
        $this->repository = $reporsitory;
        $this->em = $em;
    }
    /**
     * @Route("/admin", name="admin.property.index")
     * @return Symfony\Component\HttpFoundation\Response
     */

    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig',compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     * @param Request $request
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->HandleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'bien ajouter avec success');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/edit/{id}", name="admin.property.edit")
     * @param Property $property
     * @param Request $request
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property,Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->HandleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success', 'bien modifier avec success');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/admin/property/delete/{id}", name="admin.property.delete",methods="DELETE")
     * @param Porperty $property
     * @param Request $request
     * */
    public function delete(Property $property,Request $request)
    {
     
       if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token') ))
       {
        $this->em->remove($property);
        $this->em->flush();
        $this->addFlash('success', 'bien suprimee avec success');
        return $this->redirectToRoute('admin.property.index');
       }
        return $this->redirectToRoute('admin.property.index');
    }
}
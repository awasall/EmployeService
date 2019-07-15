<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Employer;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\EmployerRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class EmployerController extends AbstractController
{
    /**
     * @Route("/employer", name="employer")
     */
    public function index(EmployerRepository $repo)
    {
        $employer=$repo->findAll();
        return $this->render('employer/index.html.twig', [
            'controller_name' => 'EmployerController',
            'employers'=>$employer
        ]);
    }
    /**
     * @Route("/",name="acceuil")
     */
    public function acceuil()
    {
        return $this->render('employer/acceuil.html.twig');
    }
/**
 * @Route("employer/create", name="create")
 * @Route("employer/{id}/edit", name="employeredit")
 */

    public function create(Employer $employer=null, Request $request,ObjectManager $manager )
    {
        if(!$employer)
        {
            $employer=new Employer();

        }
        $form=$this->createFormBuilder($employer)
        ->add('matricule')
        ->add('prenom')
        ->add('nom')
        ->add('datenaissance',DateType::class,[
            'widget' => 'single_text'
        ])
        ->add('salaire')
        ->add('service', EntityType::class,[
            'class'=>Service::class,
            'choice_label'=>'libelle'
        ])
        ->getForm();
        $form->handleRequest($request);
if($form->isSubmitted() && $form->isValid()){
   
        $manager->persist($employer);
        $manager->flush();
        return $this->redirectToRoute('employer');
        
}
        return $this->render('employer/create.html.twig',
        ['formEmployer'=>$form->createView(),
        'editMode'=>$employer->getId() !==null
        ]);
    }

/**
* @Route("/delete/{id}",name="delete")
*/
    public function delete(Employer $employer){
        $em=$this->getDoctrine()->getManager();
        $em->remove($employer);
        $em->flush();
        return $this->redirectToRoute('employer');
               
    }
}

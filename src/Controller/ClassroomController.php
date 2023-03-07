<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class ClassroomController extends AbstractController
{
    
    #[Route('/classroomListe', name: 'app_classroom')]
    public function listeClassroom(ClassroomRepository $repo): Response
    {   $classrooms = $repo->findAll();
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
            'classrooms'=>$classrooms
        ]);
    }

    #[Route('/addClassroom', name: 'add_classroom')]
    public function addClassroom(Request $req,ManagerRegistry $doctrine){
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em=$doctrine->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('app_classroom');
        }
        
        // return $this->renderForm('classroom/add.html.twig',[
        //     'form'=>$form
        // ]);
        return $this->render('classroom/addClassroom.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/deleteClassroom/{id}', name: 'delete_classroom')]
    public function deleteClassroom($id,ManagerRegistry $doctrine){
        $classroom=$doctrine->getRepository(Classroom::class)->find($id);
        $em=$doctrine->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute('app_classroom');
    }

    #[Route('/updateClassroom/{id}', name: 'update_classroom')]
    public function updateStudent(Request $req,$id,ManagerRegistry $doctrine){
        $classroom=$doctrine->getRepository(Classroom::class)->find($id);
        $form = $this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($req);

        if($form->isSubmitted()){
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_classroom');
        }
        
        // return $this->renderForm('classroom/add.html.twig',[
        //     'form'=>$form
        // ]);
        return $this->render('classroom/addClassroom.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}

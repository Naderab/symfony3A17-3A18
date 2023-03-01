<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

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
    public function addClassroom(ManagerRegistry $doctrine){
        $classroom = new Classroom();
        $classroom->setName('test persist');
        $em=$doctrine->getManager();
        $em->persist($classroom);
        $em->flush();
        return $this->redirectToRoute('app_classroom');
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
    public function updateStudent($id,ManagerRegistry $doctrine){
        $classroom=$doctrine->getRepository(Classroom::class)->find($id);
        $classroom->setUsername('test update');
        $em=$doctrine->getManager();
        //$em->persist($student);
        $em->flush();
        return $this->redirectToRoute('app_classroom');
    }
}

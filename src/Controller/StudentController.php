<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\SearchStudentType;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    // #[Route('/student', name: 'app_student')]
    // public function index(StudentRepository $repo): Response
    // {
    //     $students = $repo->findAll();
    //     return $this->render('student/index.html.twig', [
    //         'controller_name' => 'StudentController',
    //         'students'=>$students
    //     ]);
    // }

    #[Route('/student', name: 'app_student')]
    public function index(Request $req,ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Student::class);
        $form = $this->createForm(SearchStudentType::class);
        $form->handleRequest($req);
        $students = $repo->findAll();
        if($form->isSubmitted())
        {
            $students = $repo->searchByName($form->getData('search'));
            return $this->render('student/index.html.twig', [
                'controller_name' => 'StudentController',
                'form'=>$form->createView(),
                'students'=>$students
            ]);
        }
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
            'form'=>$form->createView(),
            'students'=>$students
        ]);
    }

    #[Route('/deleteStudent/{id}', name: 'delete_student')]
    public function deleteStudent($id,ManagerRegistry $doctrine){
        $student=$doctrine->getRepository(Student::class)->find($id);
        $em=$doctrine->getManager();
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute('app_student');
    }

    #[Route('/addStudent', name: 'add_student')]
    public function addStudent(ManagerRegistry $doctrine,Request $req){
        $student = new Student();
        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($req);

        // $student->setUsername('test persist');
        // $student->setEmail('persit@test.com');
        if($form->isSubmitted()){
            $em=$doctrine->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute('app_student');
        }
        
        // return $this->renderForm('student/add.html.twig',[
        //     'form'=>$form
        // ]);
        return $this->render('student/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/updateStudent/{id}', name: 'update_student')]
    public function updateStudent(Request $req,$id,ManagerRegistry $doctrine){
        $student=$doctrine->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($req);
        // $student->setUsername('test persist');
        // $student->setEmail('persit@test.com');
        if($form->isSubmitted()){
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_student');
        }
        
        // return $this->renderForm('student/add.html.twig',[
        //     'form'=>$form
        // ]);
        return $this->render('student/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/studentByEmail',name:'student_byemail')]
    public function studentListOrderedByEmail(StudentRepository $repo){
        $students = $repo->StudentOrderedByEmail();
        return $this->render('student/index.html.twig',[
            'students'=>$students
        ]);
    }

    #[Route('/studentByClassroom/{idC}',name:'student_byClassroom')]
    public function studentsByClassroom($idC,StudentRepository $repo){
        $students = $repo->getStudentByClassroom($idC);
        return $this->render('student/byClass.html.twig',[
            'students'=>$students
        ]);
    }
}

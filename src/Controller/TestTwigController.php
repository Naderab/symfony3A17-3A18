<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestTwigController extends AbstractController
{
    #[Route('/test/twig', name: 'app_test_twig')]
    public function index(): Response
    {
        $test="Hello 3A17/3A18";
        $persons=array(array('id'=>1,'name'=>'foulen','email'=>'foulen@gmail.com'),array('id'=>2,'name'=>'foulen2','email'=>'foulen2@gmail.com'));
        return $this->render('test_twig/index.html.twig', [
            'controller_name' => 'TestTwigController',
            'testRender'=>$test,
            'tabP'=>$persons
        ]);
    }

    #[Route('/list',name:'list')]
    public function list():Response {
        $formations = array(
            array('ref' => 'form147', 'Titre' => 'Formation Symfony 
           4','Description'=>'formation pratique',
            'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020', 
           'nb_participants'=>19) ,
            array('ref'=>'form177','Titre'=>'Formation SOA' ,
            'Description'=>'formation 
           theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
            'nb_participants'=>0),
            array('ref'=>'form178','Titre'=>'Formation Angular' ,
            'Description'=>'formation 
           theorique','date_debut'=>'10/06/2020','date_fin'=>'14/06/2020',
            'nb_participants'=>12));
            $formation = array();

            return $this->render('test_twig/list.html.twig',[
                'tabFormations'=>$formations,
                'tabFormation'=>$formation

            ]);
    }

    #[Route('/details/{titre}',name:'details')]
    public function details($titre) : Response {
        return $this->render('test_twig/detail.html.twig',[
            'titre'=>$titre
        ]);
    }
}

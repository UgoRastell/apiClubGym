<?php

namespace App\Controller;

use App\Entity\Clubs;
use App\Form\ClubType;
use App\Repository\ClubsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ApiPostController extends AbstractController
{
    #[Route('/api/show', name: 'app_api_post_index', methods: ['GET'])]
    public function index(ClubsRepository $clubsRepository)
    {
        return $this->json($clubsRepository->findAll(),200,[]);
    }

    #[Route('/api/show/{id}', name: 'app_api_post_getById', methods: ['GET'])]
    public function getById($id,ClubsRepository $clubsRepository)
    {
        return $this->json($clubsRepository->findOneBy(['id' => $id]),200,[]);
    }

    #[Route('/api/remove/{id}', name: 'app_api_post_deleteById', methods: ['GET'])]
    public function deleteById($id, ClubsRepository $clubsRepository, EntityManagerInterface $entityManager)
    {
    $club = $clubsRepository->find($id);

    if (!$club) {
        throw $this->createNotFoundException(sprintf('Club with id %s not found', $id));
    }

    $entityManager->remove($club);
    $entityManager->flush();

    return $this->json(null, 204);
    }
    
    #[Route('/api/add', name: 'app_api_post_add', methods: ['GET','POST'])]
    public function add(FormFactoryInterface $factory,Request $request,EntityManagerInterface $entityManager){
       
        $club = new Clubs;
        $form = $this->createForm(ClubType::class,$club);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $club->getName();  
            $entityManager->persist($club);
            $entityManager->flush();
            echo "<script type='text/javascript'>alert('Club ajouter');</script>";
        }


        $formView = $form->createView();   
        return($this->render('api_post/add.html.twig',[
            'formView' => $formView,
        ]));
    }

    #[Route('/api/update/{id}', name: 'app_api_post_update', methods: ['GET','POST'])]
    public function edit($id, ClubsRepository $clubsRepository, Request $request, EntityManagerInterface $em){
        $club=$clubsRepository->find($id);

        $form = $this->createForm(ClubType::class, $club);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->flush();
        }

        $formView = $form->createView();

        return $this->render("api_post/edit.html.twig",[
            'club' => $club,
            'formView' => $formView
        ]);
    }
}

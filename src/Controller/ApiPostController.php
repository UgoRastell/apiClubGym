<?php

namespace App\Controller;

use App\Repository\ClubsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ApiPostController extends AbstractController
{
    #[Route('/api/post', name: 'app_api_post_index', methods: ['GET'])]
    public function index(ClubsRepository $clubsRepository)
    {
        return $this->json($clubsRepository->findAll(),200,[]);
    }

    #[Route('/api/post/{id}', name: 'app_api_post_getById', methods: ['GET'])]
    public function getById($id,ClubsRepository $clubsRepository)
    {
        return $this->json($clubsRepository->findOneBy(['id' => $id]),200,[]);
    }

    // #[Route('/api/remove/{id}', name: 'app_api_post_deleteById', methods: ['GET'])]
    // public function deleteById($id,ClubsRepository $clubsRepository)
    // {
    //     return $this->json($clubsRepository->remove(['id' => $id]),200,[]);
    // }
}

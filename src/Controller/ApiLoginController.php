<?php

namespace App\Controller;


use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiLoginController extends AbstractController
{
    // #[Route('/api/login_check', name: 'app_api_login')]
    // public function index(#[CurrentUser] ?User $user): Response{
    //     if (null === $user) {
    //         return $this->json([
    //             'message' => 'missing credentials',
    //         ], Response::HTTP_UNAUTHORIZED);
    //     }
    //     // $token = "123"; // somehow create an API token for $user
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/ApiLoginController.php',
            
    //     ]);
    // }
    #[Route('/api/login_check', name: 'app_api_login')]
    public function index(): Response{
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiLoginController.php',
            
        ]);
    }
}

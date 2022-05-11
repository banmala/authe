<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class PostController extends AbstractController
{
    #[Route('/api/post', name: 'app_post')]
    public function index(#[CurrentUser] ?User $user, Request $request): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        dump($user);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PostController',
            'user'  => $user->getUserIdentifier()
        ]);
    }
}

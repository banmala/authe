<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods:['POST'])]
    // public function index(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine, Request $request): Response
    public function index(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $encoder = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizer, $encoder);
        // $method = $request->getMethod();
        $em = $doctrine->getManager();
        $user = new User();
        $data = json_decode($request->getContent(),true);

        $user -> setUsername($data['username']);
        $user -> setRoles($data['roles']);
        // $user -> setPassword($data['password']);
        $password = $data['password'];
        $hashed_password = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashed_password);

        $em -> persist($user);
        $em -> flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RegistrationController.php',
            'data' => $user
        ]);
    }
} #}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class LoginController extends AbstractController
{
    #[Route('/no/api/login_checks', name: 'app_login', methods:['POST'])]
    public function index(ManagerRegistry $doctrine, Request $request, JWTTokenManagerInterface $JWTManager): Response
    {
        $encoder = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizer, $encoder);

        $em = $doctrine->getManager();

        $data = json_decode($request->getContent(),true);
        $user = $doctrine->getRepository(User::class)->findBy(['username'=>$data['username']]);
        $plane_data = json_decode($serializer->serialize($user,'json'))[0];
        $new_user = new User();
        $new_user->setUsername($plane_data->username);
        $new_user->setPassword($plane_data->password);
        if(null === $user){
            return $this->json([
                'message' => 'User of given username not found!',
            ]);
        }
        if($new_user->getPassword() !== $data['password']){
            return $this->json([
                'message' => 'Password Doesnot Matched'
            ]);
        }

        $token = $JWTManager->create($new_user);


        return $this->json([
            'message' => 'Welcome to your new controller!',
            'token' => $token
        ]);
    }
}
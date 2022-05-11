<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiCheckController extends AbstractController
{
    public function __construct(JWTEncoderInterface $jwtEncoder)
    {
        $this->jwtEncoder = $jwtEncoder;
    }
    #[Route('/api', name: 'app_api_check')]
    public function index(Request $request): Response
    {
        $bearer = $request->headers->get('authorization');
        if($bearer){
            $auth_key = explode(" ", $bearer)[1];
            try{
                $decoded = $this->jwtEncoder->decode($auth_key);
                    $response = $this->forward('App\Controller\TestController::index', 
                    [
                        'request'  => $request
                    ]
                );
            
                return $this->json([
                    "message" => "You are now good to go!",
                    "response" => $response
                ]);
            }
            catch(JWTDecodeFailureException $ex){
                return $this->json([
                    "error" => $ex,
                ]);
            }
        }else{
            return $this->json([
                "error" => "Bearer token not found!!",
            ]);
        }
    }
}

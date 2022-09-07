<?php


namespace App\Controller\Api;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

#[Route('/api/login')]
class SecurityController extends AbstractController
{
    #[Route('/', name: 'api_login', methods: ['POST'])]
    public function login(Request $request,UserRepository $userRepository, UserPasswordHasherInterface $hasher){

        $content = json_decode($request->getContent(),true);
        $user = $userRepository->findOneBy(['email'=> $content['email']]);
        $passwordContent = $content['password'];
        $hashPasswordContent = $hasher->hashPassword($user, $passwordContent);
        if($user->getPassword() == $hashPasswordContent){
            $token = md5(microtime());
            return $this->json($token);
        }
        else{
            throw new AuthenticationException("Пароль не верный");
        }

    }
}
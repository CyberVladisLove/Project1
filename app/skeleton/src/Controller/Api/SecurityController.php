<?php


namespace App\Controller\Api;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

#[Route('/api/login')]
class SecurityController extends AbstractController
{
    #[Route('/', name: 'api_login', methods: ['POST'])]
    public function login(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $hasher, EntityManagerInterface $em){

        $content = json_decode($request->getContent(),true);
        $user = $userRepository->findOneBy(['email'=> $content['email']]);

        if($hasher->isPasswordValid($user, $content['password'])){
            $token = md5(microtime());
            $user->setToken($token);
            $em->flush();
            return $this->json("Ваш токен доступа: " . $token);
        }
        else
        {
            throw new AuthenticationException("Пароль не верный");
        }


    }
}
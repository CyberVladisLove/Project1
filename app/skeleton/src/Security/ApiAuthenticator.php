<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiAuthenticator extends AbstractAuthenticator
{
    /**
     * ApiAuthenticator constructor.
     */
    public function __construct(protected EntityManagerInterface $em, protected UserPasswordHasherInterface $hasher)
    {
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('apikey');
    }

    public function authenticate(Request $request): Passport
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $request->headers->get('apikey')]);
        //if($user == null){
       //     throw new AuthenticationException("Пользователь не найден");
            //$this->onAuthenticationFailure($request, new AuthenticationException("Пользователь не найден"));
            //return new SelfValidatingPassport(     );
       // }
       // else{
        $password = $request->query->get('password');
        $passwordStr = strval($password);
        //$hashPassword = $this->hasher->hashPassword($user, $password);
            return new SelfValidatingPassport(
                new UserBadge($request->headers->get('apikey')),

            );
      //  }
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        /* $data = [
            'message' => "авторизован"
        ];
        return new JsonResponse($data, Response::HTTP_OK); */
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}

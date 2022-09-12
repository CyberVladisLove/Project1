<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;

#[Route('/account')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'app_account', methods: ['GET'])]
    public function index(TokenStorageInterface $storage): Response
    {
        $user = $storage->getToken()->getUser();
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'user' => $user,
            'user_roles' => $user->getRoles()
        ]);
    }

    #[Route('/setAdminRole', name: 'app_account_set_admin_role', methods: ['GET', 'POST'])]
    public function setAdminRole(TokenStorageInterface $storage, EntityManagerInterface $em): Response
    {
        $user = $storage->getToken()->getUser();
        if(in_array("ROLE_ADMIN", $user->getRoles())){
            $user->setRoles(["ROLE_USER"]);
        }
        else{
            $user->setRoles(["ROLE_ADMIN","ROLE_USER"]);
        }
        $em->flush();

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'user' => $user,
            'user_roles' => $user->getRoles()
        ]);

    }
}

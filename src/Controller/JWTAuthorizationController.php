<?php

namespace App\Controller;

use App\Validator\InstallmentsSchedule;
use App\Validator\InstallmentsScheduleValidator;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Builder\ConfigBuilderGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Config\SecurityConfig;

class JWTAuthorizationController extends AbstractController
{
    private SecurityConfig $securityConfig;

//    public function __construct(private EntityManagerInterface $entityManager, SecurityConfig $securityConfig)
//    {
//        $this->securityConfig = $securityConfig;
//    }

    #[Route('/api/token/refresh', name: 'api_token_refresh', methods: 'POST')]
    public function index(Request $request): JsonResponse
    {
        $securityConfig = new SecurityConfig();

        var_dump($securityConfig->provider('my_in_memory_users'));die;
        var_dump($securityConfig->getExtensionAlias());die;

        $user = $entityManager
            ->getRepository('AppBundle:User')
            ->findOneBy(['username' => $request->getUser()]);
        if (!$user) {
            throw $this->createNotFoundException();
        }
        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $request->getPassword());
        if (!$isValid) {
            throw new BadCredentialsException();
        }
        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $user->getUsername(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);
        return new JsonResponse(['token' => $token]);
    }

//    #[Route('/api/login_check', name: 'api_login_check', methods: 'POST')]
//    public function apiLoginCheck(Request $request, EntityManagerInterface $entityManager, InstallmentsScheduleValidator $installmentsScheduleValidator): JsonResponse
//    {
//
//    }
}
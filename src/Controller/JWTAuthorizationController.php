<?php

namespace App\Controller;

use App\Validator\InstallmentsSchedule;
use App\Validator\InstallmentsScheduleValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class JWTAuthorizationController extends AbstractController
{
//    #[Route('/api/token/refresh', name: 'api_token_refresh', methods: 'POST')]
//    public function index(Request $request, EntityManagerInterface $entityManager, InstallmentsScheduleValidator $installmentsScheduleValidator): JsonResponse
//    {
//
//    }
//
//    #[Route('/api/login_check', name: 'api_login_check', methods: 'POST')]
//    public function apiLoginCheck(Request $request, EntityManagerInterface $entityManager, InstallmentsScheduleValidator $installmentsScheduleValidator): JsonResponse
//    {
//
//    }
}
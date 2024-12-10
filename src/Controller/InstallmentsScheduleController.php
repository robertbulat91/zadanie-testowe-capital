<?php

namespace App\Controller;

use App\Repository\InstallmentsScheduleRepository;
use App\Validator\InstallmentsSchedule;
use App\Validator\InstallmentsScheduleValidator;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InstallmentsScheduleController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param InstallmentsScheduleValidator $installmentsScheduleValidator
     * @return JsonResponse
     */
    #[Route('/installments_schedule/generate_schedule', name: 'app_installment_schedule', methods: 'POST')]
    public function index(Request $request, EntityManagerInterface $entityManager, InstallmentsScheduleValidator $installmentsScheduleValidator): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        if(!isset($payload[InstallmentsSchedule::LOAN_AMOUNT]) || !isset($payload[InstallmentsSchedule::NUMBER_OF_LOAN_INSTALLMENTS])) {
           return new JsonResponse(['error' => 'Loan amount and number of installments must be set'], 400);
        }

        $loanAmount = $payload[InstallmentsSchedule::LOAN_AMOUNT];
        $numberOfLoanInstallment = $payload[InstallmentsSchedule::NUMBER_OF_LOAN_INSTALLMENTS];

        $installmentsScheduleModel = new \App\Model\InstallmentsSchedule($loanAmount, $numberOfLoanInstallment);

        if(isset($installmentsScheduleModel->createAnInstallmentsSchedule()['error'])) {
            return new JsonResponse($installmentsScheduleModel->createAnInstallmentsSchedule()['error'], 400);
        }

        $installmentsSchedule = $installmentsScheduleModel->createAnInstallmentsSchedule();

        $installmentsScheduleEntity = new \App\Entity\InstallmentsSchedule();

        $installmentsScheduleEntity->setLoanInterest($installmentsScheduleModel::LOAN_INTEREST_RATE_PER_YEAR);
        $installmentsScheduleEntity->setLoanAmount($installmentsScheduleModel->getLoanAmount());
        $installmentsScheduleEntity->setNumberOfLoanInstallments($installmentsScheduleModel->getNumberOfLoanInstallments());
        $installmentsScheduleEntity->setCalculationDate($installmentsScheduleModel->getCalculationDate());
        $installmentsScheduleEntity->setInstallmentsSchedule($installmentsSchedule);
        $installmentsScheduleEntity->setTotalAmountOfInterest($installmentsScheduleModel->getTotalAmountOfInterest());
        $installmentsScheduleEntity->setStatus(true);

        $entityManager->persist($installmentsScheduleEntity);
        $entityManager->flush();

        return $this->json([
            $installmentsSchedule
        ]);
    }

    /**
     * @param Request $request
     * @param InstallmentsScheduleRepository $installmentsScheduleRepository
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    #[Route('/installments_schedule/exclude_schedule', name: 'app_exclude_schedule', methods: 'POST')]
    public function excludeSchedule(Request $request, InstallmentsScheduleRepository $installmentsScheduleRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        /**
         * @TODO implement JWT
         */
        $payload = json_decode($request->getContent(), true);
        $scheduleId = $payload['id'];

        if(!isset($payload['id'])) {
            return new JsonResponse(['error' => 'Id is not set!'], 400);
        }

        $installmentScheduleEntity = $installmentsScheduleRepository->find($scheduleId);

        if($installmentScheduleEntity->isStatus())
        {
            return $this->json(['Installments schedule no. ' .
                $installmentScheduleEntity->getId() . 'is already excluded.'
            ]);
        }

        $installmentScheduleEntity->setStatus(false);

        $entityManager->persist($installmentScheduleEntity);
        $entityManager->flush();


        return $this->json(['Installments schedule no. ' .
            $installmentScheduleEntity->getId() . 'was excluded.'
        ]);
    }

    /**
     * @param Request $request
     * @param InstallmentsScheduleRepository $installmentsScheduleRepository
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    #[Route('/installments_schedule/list_schedule', name: 'app_list_schedule', methods: 'POST')]
    public function listSchedule(Request $request, InstallmentsScheduleRepository $installmentsScheduleRepository, EntityManagerInterface $entityManager): Response
    {
        /**
         * @TODO implement JWT
         */
        $payload = json_decode($request->getContent(), true);

        $criteria = [];
        if (isset($payload['onlyNotExcluded'])) {
            $criteria['status'] = true;
        }

        $installmentSchedulelist = $installmentsScheduleRepository->findBy($criteria);
        $serializer = SerializerBuilder::create()->build();

        $installmentSchedulelistJSON = $serializer->serialize($installmentSchedulelist, 'json');

        return new JsonResponse($installmentSchedulelistJSON);
    }
}
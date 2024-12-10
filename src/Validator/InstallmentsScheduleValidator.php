<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class InstallmentsScheduleValidator extends ConstraintValidator
{

    public function validate(mixed $value, Constraint $constraint): array
    {
        /* @var InstallmentsSchedule $constraint */

        if (null === $value || '' === $value) {
            return array(['error' => 'Value is empty!']);
        }

        if(($value[InstallmentsSchedule::LOAN_AMOUNT] % InstallmentsSchedule::LOAN_AMOUNT_DIVIDED_BY) > 0) {
            return ['error' => 'Value is empty!'];
        }

        if( $value[InstallmentsSchedule::LOAN_AMOUNT] < 1000  ||
            $value[InstallmentsSchedule::LOAN_AMOUNT] > 12000) {
            return ['error' => 'Loan amount cannot be less than 1000 and greater than 12000!'];
        }

        if(($value[InstallmentsSchedule::LOAN_AMOUNT] % InstallmentsSchedule::LOAN_AMOUNT_DIVIDED_BY) > 0) {
            return ['error' => 'Loan amount could be divided only by 500!'];
        }

        if(($value[InstallmentsSchedule::NUMBER_OF_LOAN_INSTALLMENTS] % InstallmentsSchedule::NUMBER_OF_INSTALLMENTS_DIVIDED_BY))
        {
            return ['error' => 'Loan installments could be divided only by 3.'];
        }


        return array();
    }
}

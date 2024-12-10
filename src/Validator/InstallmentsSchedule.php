<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class InstallmentsSchedule extends Constraint
{
    CONST LOAN_AMOUNT = 'loanAmount';
    CONST NUMBER_OF_LOAN_INSTALLMENTS = 'numberOfLoanInstallments';

    CONST LOAN_AMOUNT_DIVIDED_BY = 500;

    CONST NUMBER_OF_INSTALLMENTS_DIVIDED_BY = 3;

    CONST LOAN_AMOUNT_GREATER_THAN = 1000;

    CONST LOAN_AMOUNT_LESS_THAN = 1000;
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public string $message = 'The value "{{ value }}" is not valid.';
}

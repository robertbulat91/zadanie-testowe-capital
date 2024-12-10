<?php

namespace App\Model;

use App\Validator\InstallmentsScheduleValidator;

class InstallmentsSchedule
{
    private int $loanAmount;
    private int $numberOfLoanInstallments;
    private float $installmentAmount;
    private float $totalAmountOfInterest;

    /**
     * Oprocentowanie może być również definiowane wcześniej
     */
//    private $loanInterestRate;
    private \DateTime $calculationDate;

    public function __construct(int $loanAmount, int $numberOfLoanInstallments)
    {
        $this->loanAmount = $loanAmount;
        $this->numberOfLoanInstallments = $numberOfLoanInstallments;
    }

    CONST LOAN_INTEREST_RATE_PER_YEAR = 0.03;

    CONST NUMBER_OF_LOAN_INSTALLMENTS_PER_YEAR = 12;

    public function setLoanAmount($loanAmount): void
    {
        $this->loanAmount *= $loanAmount;
    }

    public function getLoanAmount(): int
    {
        return $this->loanAmount;
    }

    public function setNumberOfLoanInstallments($numberOfLoanInstallments): void
    {
        $this->numberOfLoanInstallments = $numberOfLoanInstallments;
    }

    public function getNumberOfLoanInstallments(): int
    {
        return $this->numberOfLoanInstallments;
    }

    public function setCalculationDate(\DateTime $calculationDate): void
    {
        $this->calculationDate = $calculationDate;
    }

    public function getCalculationDate(): \DateTime
    {
        if(!$this->calculationDate) {
            throw new \LogicException('Calculation Date not set');
        }
        return $this->calculationDate;
    }

    public function setInstallmentAmount(float $installmentAmount): void
    {
        $this->installmentAmount = $installmentAmount;
    }

    public function getInstallmentAmount(): float
    {
        if(!$this->installmentAmount) {
            throw new \LogicException('Installment Amount not set');
        }
        return $this->installmentAmount;
    }

    public function setTotalAmountOfInterest(float $totalAmountOfInterest): void
    {
        $this->totalAmountOfInterest = $totalAmountOfInterest;
    }

    public function getTotalAmountOfInterest(): float
    {
        if(!$this->totalAmountOfInterest) {
            throw new \LogicException('Total amount of  interest not set');
        }
        return $this->totalAmountOfInterest;
    }

    public function  createAnInstallmentsSchedule(): array
    {
        $installmentsSchedule = [];

        $value['loanAmount'] = $this->loanAmount;
        $value['numberOfLoanInstallments'] = $this->numberOfLoanInstallments;


        $installmentsScheduleValidator = new InstallmentsScheduleValidator();
        $errors = $installmentsScheduleValidator->validate($value, new \App\Validator\InstallmentsSchedule());

        if(ISSET($errors['error'])) {
            return $errors;
        }

        $this->calculationDate = new \DateTime();

        /***
         * Wzór na wyliczenie wysokości raty
         */
        $installmentAmount = $this->loanAmount * (((self::LOAN_INTEREST_RATE_PER_YEAR/self::NUMBER_OF_LOAN_INSTALLMENTS_PER_YEAR)*pow(1+(self::LOAN_INTEREST_RATE_PER_YEAR/self::NUMBER_OF_LOAN_INSTALLMENTS_PER_YEAR),$this->numberOfLoanInstallments)
                /
                (pow((1+(self::LOAN_INTEREST_RATE_PER_YEAR/self::NUMBER_OF_LOAN_INSTALLMENTS_PER_YEAR)),($this->numberOfLoanInstallments))-1)
            ));

        $this->installmentAmount = $installmentAmount;

        $installmentsSchedule['CALCULATION METRIC']['MOMENT_OF_CALCULATION'] = $this->calculationDate;
        $installmentsSchedule['CALCULATION METRIC']['NUMBER_OF_INSTALLMENTS'] = $this->calculationDate;
        $installmentsSchedule['CALCULATION METRIC']['LOAN_AMOUNT'] = $this->loanAmount;
        $installmentsSchedule['CALCULATION METRIC']['CAPITAL_AMOUNT'] = $installmentAmount*$this->numberOfLoanInstallments;

        $this->totalAmountOfInterest = $this->installmentAmount*$this->numberOfLoanInstallments-$this->loanAmount;

        for ($i=1; $i <= $this->numberOfLoanInstallments; $i++) {
            $installmentsSchedule['INSTALLMENT SCHEDULE'][$i] = [
                'NUMBER OF INSTALLMENT' => $i,
                'INSTALLMENT AMOUNT' => $installmentAmount,
                'INTEREST AMOUNT' => ($this->loanAmount)*self::LOAN_INTEREST_RATE_PER_YEAR*($this->numberOfLoanInstallments/self::NUMBER_OF_LOAN_INSTALLMENTS_PER_YEAR),
                'CAPITAL AMOUNT' => ($installmentAmount*($this->numberOfLoanInstallments-$i))
                ];
        }


        return $installmentsSchedule;
    }

}
<?php

namespace App\Entity;

use App\Repository\InstallmentsScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstallmentsScheduleRepository::class)]
class InstallmentsSchedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $loanInterest = null;

    #[ORM\Column]
    private array $installmentsSchedule = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $calculationDate = null;

    #[ORM\Column]
    private ?int $numberOfLoanInstallments = null;

    #[ORM\Column]
    private ?float $loanAmount = null;

    #[ORM\Column(options: ["default" => true])]
    private ?bool $status = null;

    #[ORM\Column]
    private ?float $totalAmountOfInterest = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoanInterest(): ?float
    {
        return $this->loanInterest;
    }

    public function setLoanInterest(float $loanInterest): static
    {
        $this->loanInterest = $loanInterest;

        return $this;
    }

    public function getInstallmentsSchedule(): array
    {
        return $this->installmentsSchedule;
    }

    public function setInstallmentsSchedule(array $installmentsSchedule): static
    {
        $this->installmentsSchedule = $installmentsSchedule;

        return $this;
    }

    public function getCalculationDate(): ?\DateTimeInterface
    {
        return $this->calculationDate;
    }

    public function setCalculationDate(\DateTimeInterface $calculationDate): static
    {
        $this->calculationDate = $calculationDate;

        return $this;
    }

    public function getNumberOfLoanInstallments(): ?int
    {
        return $this->numberOfLoanInstallments;
    }

    public function setNumberOfLoanInstallments(int $numberOfLoanInstallments): static
    {
        $this->numberOfLoanInstallments = $numberOfLoanInstallments;

        return $this;
    }

    public function getLoanAmount(): ?float
    {
        return $this->loanAmount;
    }

    public function setLoanAmount(float $loanAmount): static
    {
        $this->loanAmount = $loanAmount;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTotalAmountOfInterest(): ?float
    {
        return $this->totalAmountOfInterest;
    }

    public function setTotalAmountOfInterest(float $totalAmountOfInterest): static
    {
        $this->totalAmountOfInterest = $totalAmountOfInterest;

        return $this;
    }

}

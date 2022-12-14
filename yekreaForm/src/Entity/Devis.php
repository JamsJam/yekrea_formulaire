<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DevisRepository::class)
 */
class Devis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numDevis;

    /**
     * @ORM\OneToOne(targetEntity=Command::class, inversedBy="devis", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $command;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix_final;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $service;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $service_detail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $materiel;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $clientDecisionDate;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumDevis(): ?int
    {
        return $this->numDevis;
    }

    public function setNumDevis(int $numDevis): self
    {
        $this->numDevis = $numDevis;

        return $this;
    }

    public function getCommand(): ?Command
    {
        return $this->command;
    }

    public function setCommand(Command $command): self
    {
        $this->command = $command;

        return $this;
    }

    public function getPrixFinal(): ?float
    {
        return $this->prix_final;
    }

    public function setPrixFinal(?float $prix_final): self
    {
        $this->prix_final = $prix_final;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getServiceDetail(): ?string
    {
        return $this->service_detail;
    }

    public function setServiceDetail(string $service_detail): self
    {
        $this->service_detail = $service_detail;

        return $this;
    }

    public function getMateriel(): ?string
    {
        return $this->materiel;
    }

    public function setMateriel(?string $materiel): self
    {
        $this->materiel = $materiel;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getClientDecisionDate(): ?\DateTimeInterface
    {
        return $this->clientDecisionDate;
    }

    public function setClientDecisionDate(?\DateTimeInterface $clientDecisionDate): self
    {
        $this->clientDecisionDate = $clientDecisionDate;

        return $this;
    }


    
}

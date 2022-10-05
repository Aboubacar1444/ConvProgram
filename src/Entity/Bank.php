<?php

namespace App\Entity;

use App\Repository\BankRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BankRepository::class)]
class Bank
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 2000)]
    private ?string $idusersama = null;

    #[ORM\Column(length: 2000)]
    private ?string $phoneuser = null;

    #[ORM\Column]
    private ?int $mnoid = null;

    #[ORM\Column(length: 255)]
    private ?string $banque = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $idtransSama = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $idtransBanque = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $transfertAt = null;

    #[ORM\Column(length: 255)]
    private ?string $serviceName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $entryType = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column]
    private ?float $postBalance = null;

    #[ORM\Column]
    private ?float $frais = null;

    #[ORM\Column(length: 500)]
    private ?string $imei = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $saveAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $erreur = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $mclientsama = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $aversclient = null;

    #[ORM\Column(nullable: true)]
    private ?int $idExcel = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 355, nullable: true)]
    private ?string $receveirMsisdn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIdusersama(): ?string
    {
        return $this->idusersama;
    }

    public function setIdusersama(string $idusersama): self
    {
        $this->idusersama = $idusersama;

        return $this;
    }

    public function getPhoneuser(): ?string
    {
        return $this->phoneuser;
    }

    public function setPhoneuser(string $phoneuser): self
    {
        $this->phoneuser = $phoneuser;

        return $this;
    }

    public function getMnoid(): ?int
    {
        return $this->mnoid;
    }

    public function setMnoid(int $mnoid): self
    {
        $this->mnoid = $mnoid;

        return $this;
    }

    public function getBanque(): ?string
    {
        return $this->banque;
    }

    public function setBanque(string $banque): self
    {
        $this->banque = $banque;

        return $this;
    }

    public function getIdtransSama(): ?string
    {
        return $this->idtransSama;
    }

    public function setIdtransSama(string $idtransSama): self
    {
        $this->idtransSama = $idtransSama;

        return $this;
    }

    public function getIdtransBanque(): ?string
    {
        return $this->idtransBanque;
    }

    public function setIdtransBanque(?string $idtransBanque): self
    {
        $this->idtransBanque = $idtransBanque;

        return $this;
    }

    public function getTransfertAt(): ?\DateTimeImmutable
    {
        return $this->transfertAt;
    }

    public function setTransfertAt(\DateTimeImmutable $transfertAt): self
    {
        $this->transfertAt = $transfertAt;

        return $this;
    }

    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $serviceName): self
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    public function getEntryType(): ?string
    {
        return $this->entryType;
    }

    public function setEntryType(?string $entryType): self
    {
        $this->entryType = $entryType;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getPostBalance(): ?float
    {
        return $this->postBalance;
    }

    public function setPostBalance(float $postBalance): self
    {
        $this->postBalance = $postBalance;

        return $this;
    }

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getImei(): ?string
    {
        return $this->imei;
    }

    public function setImei(string $imei): self
    {
        $this->imei = $imei;

        return $this;
    }

    public function getSaveAt(): ?\DateTimeImmutable
    {
        return $this->saveAt;
    }

    public function setSaveAt(\DateTimeImmutable $saveAt): self
    {
        $this->saveAt = $saveAt;

        return $this;
    }

    public function getErreur(): ?string
    {
        return $this->erreur;
    }

    public function setErreur(?string $erreur): self
    {
        $this->erreur = $erreur;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getMclientsama(): ?string
    {
        return $this->mclientsama;
    }

    public function setMclientsama(?string $mclientsama): self
    {
        $this->mclientsama = $mclientsama;

        return $this;
    }

    public function getAversclient(): ?string
    {
        return $this->aversclient;
    }

    public function setAversclient(?string $aversclient): self
    {
        $this->aversclient = $aversclient;

        return $this;
    }

    public function getIdExcel(): ?int
    {
        return $this->idExcel;
    }

    public function setIdExcel(?int $idExcel): self
    {
        $this->idExcel = $idExcel;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getReceveirMsisdn(): ?string
    {
        return $this->receveirMsisdn;
    }

    public function setReceveirMsisdn(?string $receveirMsisdn): self
    {
        $this->receveirMsisdn = $receveirMsisdn;

        return $this;
    }
}

<?php

namespace toubeelib\core\domain\entities\rdv;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\domain\entities\praticien\Specialite;
use toubeelib\core\dto\RdvDTO;

class RendezVous extends Entity
{
    protected string $ID_praticien;
    protected string $ID_patient;
    protected string|null $specialite = null;
    protected \DateTime $date;
    protected bool $estAnnule = false;

    protected string $statut = "prévu";

    public function __construct(string $ID_praticien, string $ID_patient, string $specialite, \DateTime $date)
    {
        $this->ID_praticien = $ID_praticien;
        $this->ID_patient = $ID_patient;
        $this->specialite = $specialite;
        $this->date = $date;
    }

    public function annuler(): void
    {
        $this->estAnnule = true;
        $this->statut = "annulé";
    }

    public function updateStatut(string $newStatut): void
    {
        $this->statut = $newStatut;
    }

    public function toDTO(): RdvDTO
    {
        return new RdvDTO($this);
    }

    public function setID_patient(string $ID_patient)
    {
        $this->ID_patient = $ID_patient;
    }

    public function setSpecialite(string $specialite)
    {
        $this->specialite = $specialite;
    }

    public function setID_praticien(string $ID_praticien)
    {
        $this->ID_praticien = $ID_praticien;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function setEstAnnule(bool $estAnnule)
    {
        $this->estAnnule = $estAnnule;
    }

    public function setStatut(string $statut)
    {
        $this->statut = $statut;
    }

    public function getID_praticien(): string
    {
        return $this->ID_praticien;
    }

    public function getID_patient(): string
    {
        return $this->ID_patient;
    }

    public function getSpecialite(): string
    {
        return $this->specialite;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getEstAnnule(): bool
    {
        return $this->estAnnule;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getID(): string
    {
        return $this->ID;
    }

}
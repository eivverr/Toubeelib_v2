<?php

namespace toubeelib\app\praticiens\core\domain\entities\praticien;

use toubeelib\app\praticiens\core\domain\entities\Entity;
use toubeelib\app\praticiens\core\dto\PraticienDTO;

class Praticien extends Entity
{
    // Propriétés
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    protected ?Specialite $specialite = null; // version simplifiée : une seule spécialité

    public function __construct(string $nom, string $prenom, string $adresse, string $tel)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->tel = $tel;
    }

    public function setSpecialite(Specialite $specialite): void
    {
        $this->specialite = $specialite;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function toDTO(): PraticienDTO
    {
        return new PraticienDTO($this);
    }
}
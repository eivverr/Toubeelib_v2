<?php

namespace toubeelib\app\rdvs\core\dto;

use toubeelib\app\rdvs\core\domain\entities\praticien\Specialite;
use toubeelib\app\rdvs\core\domain\entities\rdv\RendezVous;
use toubeelib\app\rdvs\core\dto\DTO;

class RdvDTO extends DTO
{

    protected string $ID;
    protected string $ID_praticien;
//    protected string $nom_praticien;
//    protected string $prenom_praticien;
//    protected string $adresse_praticien;
//    protected string $tel_praticien;
    protected string $ID_patient;
    protected \DateTime $date;
    protected bool $estAnnule;
//    protected string $specialite_label;

    public function __construct(RendezVous $rdv)
    {
        $this->ID = $rdv->ID;
        $this->ID_praticien = $rdv->ID_praticien;
//        $this->nom_praticien = $rdv->praticien->nom;
//        $this->prenom_praticien = $rdv->praticien->prenom;
//        $this->adresse_praticien = $rdv->praticien->adresse;
//        $this->tel_praticien = $rdv->praticien->tel;
        $this->ID_patient = $rdv->ID_patient;
        $this->date = $rdv->date;
        $this->estAnnule = $rdv->estAnnule;
//        $this->specialite_label = $rdv->specialite->label;
    }

}
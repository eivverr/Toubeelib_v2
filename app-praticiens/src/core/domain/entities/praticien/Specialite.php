<?php

namespace toubeelib\app\praticiens\core\domain\entities\praticien;

use toubeelib\app\praticiens\core\domain\entities\Entity;
use toubeelib\app\praticiens\core\dto\SpecialiteDTO;

class Specialite extends Entity
{

    protected string $label;
    protected string $description;

    public function __construct(string $label, string $description)
    {
        $this->label = $label;
        $this->description = $description;
    }

    public function toDTO(): SpecialiteDTO
    {
        return new SpecialiteDTO($this->ID, $this->label, $this->description);

    }
}
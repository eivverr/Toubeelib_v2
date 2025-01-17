<?php

namespace toubeelib\core\domain\entities\praticien;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\SpecialiteDTO;

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
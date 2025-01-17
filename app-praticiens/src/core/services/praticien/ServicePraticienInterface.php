<?php

namespace toubeelib\app\praticiens\core\services\praticien;

use toubeelib\app\praticiens\core\dto\InputPraticienDTO;
use toubeelib\app\praticiens\core\dto\PraticienDTO;
use toubeelib\app\praticiens\core\dto\SpecialiteDTO;

interface ServicePraticienInterface
{

    public function createPraticien(InputPraticienDTO $p): PraticienDTO;
    public function getPraticienById(string $id): PraticienDTO;
    public function getSpecialiteById(string $id): SpecialiteDTO;


}
<?php

namespace toubeelib\app\rdvs\core\services\praticien;

use toubeelib\app\rdvs\core\dto\PraticienDTO;

interface ServicePraticienInterface
{
    public function getPraticienById(string $id): PraticienDTO;

}
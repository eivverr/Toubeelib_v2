<?php

namespace toubeelib\app\praticiens\core\repositoryInterfaces;

use toubeelib\app\praticiens\core\domain\entities\praticien\Praticien;
use toubeelib\app\praticiens\core\domain\entities\praticien\Specialite;

interface PraticienRepositoryInterface
{

    public function getSpecialiteById(string $id): Specialite;
    public function save(Praticien $praticien): string;
    public function getPraticienById(string $id): Praticien;

}
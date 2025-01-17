<?php

namespace toubeelib\app\praticiens\core\services\praticien;

use Respect\Validation\Exceptions\NestedValidationException;
use toubeelib\app\praticiens\core\domain\entities\praticien\Praticien;
use toubeelib\app\praticiens\core\dto\InputPraticienDTO;
use toubeelib\app\praticiens\core\dto\PraticienDTO;
use toubeelib\app\praticiens\core\dto\SpecialiteDTO;
use toubeelib\app\praticiens\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\app\praticiens\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ServicePraticien implements ServicePraticienInterface
{
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function createPraticien(InputPraticienDTO $p): PraticienDTO
    {
        // TODO : valider les données et créer l'entité
        return new PraticienDTO($p);


    }

    public function getPraticienById(string $id): PraticienDTO
    {
        try {
            $praticien = $this->praticienRepository->getPraticienById($id);
            return new PraticienDTO($praticien);
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServicePraticienInvalidDataException('invalid Praticien ID');
        }
    }

    public function getAllPraticiens(): array
    {
        $praticiens = $this->praticienRepository->getAllPraticiens();
        return array_map(function(Praticien $p) {
            return $p->toDTO();
        }, $praticiens);
    }

    public function getSpecialiteById(string $id): SpecialiteDTO
    {
        try {
            $specialite = $this->praticienRepository->getSpecialiteById($id);
            return $specialite->toDTO();
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServicePraticienInvalidDataException('invalid Specialite ID');
        }
    }

}
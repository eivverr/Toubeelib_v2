<?php

namespace toubeelib\app\rdvs\core\services\rdv;

use DateTime;
use toubeelib\app\rdvs\core\dto\RdvDTO;
use toubeelib\app\rdvs\core\dto\InputRdvDTO;
use toubeelib\app\rdvs\core\repositoryInterfaces\RdvRepositoryInterface;
use toubeelib\app\rdvs\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\app\rdvs\core\services\praticien\ServicePraticienInterface;
use toubeelib\app\rdvs\core\services\rdv\ServiceRdvInterface;

class ServiceRdv implements ServiceRdvInterface
{
    public const DUREE_RDV = 30;
    public const HEURE_DEBUT = 8;
    public const HEURE_FIN = 17;
    public const HEURE_PAUSE_DEBUT = 12;
    public const HEURE_PAUSE_FIN = 13;
    public const JOURS_TRAVAIL = [1, 2, 3, 4, 5];

    private ServicePraticienInterface $praticienService;
    private RdvRepositoryInterface $rdvRepository;

    public function __construct(ServicePraticienInterface $praticienService, RdvRepositoryInterface $rdvRepository)
    {
        $this->praticienService = $praticienService;
        $this->rdvRepository = $rdvRepository;
    }

    public function getRdvById(string $id): RdvDTO
    {
        try {
            $rdv = $this->rdvRepository->getRdvById($id);
            return new RdvDTO($rdv);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRdvInvalidDataException('Invalid Rdv ID');
        }
    }

    public function creerRendezVous(InputRdvDTO $rdv): RdvDTO
    {
        $praticien = $this->praticienService->getPraticienById($rdv->getID_praticien());
        if ($praticien === null) {
            throw new ServiceRdvInvalidDataException('Invalid praticien ID');
        }

        if ($praticien->getSpecialite() === $rdv->getSpecialite()) {
            throw new ServiceRdvInvalidDataException('Invalid specialite');
        }

        $rdvs = $this->rdvRepository->getRdvsByPraticienId($rdv->getID_praticien(), $rdv->getDate(), $rdv->getDate());
        if ($rdvs !== null) {
            throw new ServiceRdvInvalidDataException('Praticien not available');
        }

        $rdvCreated = $this->rdvRepository->creerRendezVous($rdv);
        return new RdvDTO($rdvCreated);
    }

    public function annulerRendezVous(string $id): void
    {
        try {
            $rdv = $this->rdvRepository->getRdvById($id);
            $rdv->annuler();
            $this->rdvRepository->updateRdv($rdv);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRdvInvalidDataException('Invalid Rdv ID');
        }
    }

    public function getDisponibilitesPraticien(string $id, DateTime $fromDate, DateTime $toDate): array
    {
        try {
            $disponibilites = [];
            $date = clone $fromDate;
            while ($date <= $toDate) {
                if (in_array($date->format('N'), self::JOURS_TRAVAIL)) {
                    $heure = self::HEURE_DEBUT;
                    while ($heure < self::HEURE_FIN) {
                        if (!($date->format('H') == self::HEURE_PAUSE_DEBUT && $heure >= self::HEURE_PAUSE_DEBUT && $heure < self::HEURE_PAUSE_FIN)) {
                            $disponibilites[] = clone $date->setTime($heure, 0);
                        }
                        // Instead of increasing by a float, cast the value to an integer
                        $heure += self::DUREE_RDV;  // DUREE_RDV is already in minutes, so this avoids the float-to-int issue.
                    }
                }
                $date->modify('+1 day');
            }

            $rdvs = $this->rdvRepository->getRdvsByPraticienId($id, $fromDate, $toDate);
            foreach ($rdvs as $rdv) {
                $date = $rdv->getDate();
                $key = array_search($date, $disponibilites);
                if ($key !== false) {
                    unset($disponibilites[$key]);
                }
            }

            return $disponibilites;
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRdvInvalidDataException('Invalid Praticien ID');
        }
    }


    public function getPatientRdvs(string $id): array
    {
        try {
            return $this->rdvRepository->getRdvsByPatientId($id);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRdvInvalidDataException('Invalid Patient ID');
        }
    }

    public function modifierSpecialiteRendezVous(string $id, string $specialite): void
    {
        try {
            $rdv = $this->rdvRepository->getRdvById($id);
            $rdv->setSpecialite($specialite);
            $this->rdvRepository->updateRdv($rdv);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRdvInvalidDataException('Invalid Rdv ID');
        }
    }

    public function modifierPatientRendezVous(string $id, string $ID_patient): void
    {
        try {
            $rdv = $this->rdvRepository->getRdvById($id);
            $rdv->setID_patient($ID_patient);
            $this->rdvRepository->updateRdv($rdv);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRdvInvalidDataException('Invalid Rdv ID');
        }
    }
}

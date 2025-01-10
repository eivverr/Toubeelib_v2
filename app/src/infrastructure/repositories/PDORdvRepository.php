<?php

namespace toubeelib\infrastructure\repositories;

use PDO;
use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\rdv\RendezVous;
use toubeelib\core\dto\InputRdvDTO;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class PDORdvRepository implements RdvRepositoryInterface
{
    private array $rdvs = [];

    public function __construct() {
        $dbCredentials = parse_ini_file(__DIR__ . '/../../../config/toubeelibdb.env');
        $data = new PDO('pgsql:host=toubeelib.db;dbname=toubeelib', $dbCredentials["POSTGRES_USER"], $dbCredentials["POSTGRES_PASSWORD"]);
        $stmt = $data->query('SELECT * FROM rdvs');
        $rdvs = $stmt->fetchAll();
        foreach ($rdvs as $rdv){
            $timestamp = $rdv['daterdv'];
            $date = new \DateTime("$timestamp");
            $this->rdvs[$rdv['id']] = new RendezVous($rdv["id_user"], $rdv["id_user"], $rdv['id_specialite'], $date);
            $this->rdvs[$rdv['id']]->setID($rdv['id']);
        }
    }


    public function getRdvById(string $id): RendezVous
    {
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException('RendezVous not found');
        }
        return $this->rdvs[$id];
    }

    public function creerRendezVous(InputRdvDTO $rdv)
    {
        $r = new RendezVous($rdv->getID_praticien(), $rdv->getID_patient(), $rdv->getSpecialite(), \DateTimeImmutable::createFromFormat('Y-m-d H:i', $rdv->getDate()));
        $r->setID(Uuid::uuid4()->toString());
        $this->rdvs[$r->getID()] = $r;
        return $r;
    }

    public function updateRdv(RendezVous $rdv): void
    {
        $this->rdvs[$rdv->getID()] = $rdv;
    }

    public function getRdvsByPraticienId(string $id, \DateTime $fromDate, \DateTime $toDate): array
    {
        $rdvs = [];
        foreach ($this->rdvs as $rdv) {
            if ($rdv->getID_praticien() === $id && $rdv->getDate() >= $fromDate && $rdv->getDate() <= $toDate) {
                $rdvs[] = $rdv;
            }
        }
        return $rdvs;
    }

    public function getRdvsByPatientId(string $id): array
    {
        $rdvs = [];
        foreach ($this->rdvs as $rdv) {
            if ($rdv->getID_patient() === $id) {
                $rdvs[] = $rdv;
            }
        }
        return $rdvs;
    }
}
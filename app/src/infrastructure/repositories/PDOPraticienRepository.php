<?php

namespace toubeelib\infrastructure\repositories;

use PDO;
use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\praticien\Specialite;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class PDOPraticienRepository implements PraticienRepositoryInterface
{

    private array $specialites = [];

    private array $praticiens = [];

    public function __construct() {
        $dataCredentials = parse_ini_file(__DIR__ . '/../../../config/toubeelibdb.env');
        $data = new PDO('pgsql:host=toubeelib.db;dbname=toubeelib', $dataCredentials["POSTGRES_USER"], $dataCredentials["POSTGRES_PASSWORD"]);
        $stmt = $data->query('SELECT * FROM PRATICIEN');
        $praticiens = $stmt->fetchAll();
        foreach ($praticiens as $praticien) {
            $this->praticiens[$praticien['id']] = new Praticien($praticien['nom'], $praticien['prenom'], $praticien['adresse'], $praticien['tel']);
            $this->praticiens[$praticien['id']]->setID($praticien['id']);
        }

        $stmt = $data->query('SELECT * FROM SPECIALITE');
        $specialites = $stmt->fetchAll();
        foreach ($specialites as $specialite) {
            $this->specialites[$specialite['id']] = new Specialite($specialite['label'], $specialite['description']);
            $this->specialites[$specialite['id']]->setID($specialite['id']);
        }

        $stmt = $data->query('SELECT * FROM specialitepraticien');
        $praticiens_specialites = $stmt->fetchAll();
        foreach ($praticiens_specialites as $praticien_specialite) {
            $this->praticiens[$praticien_specialite['id_praticien']]->setSpecialite($this->specialites[$praticien_specialite['id_specialite']]);
        }
    }
    public function getSpecialiteById(string $id): Specialite
    {

        $specialite = $this->specialites[$id] ??
            throw new RepositoryEntityNotFoundException("Specialite $id not found") ;

        return new Specialite($specialite['id'], $specialite['label'], $specialite['description']);
    }

    public function save(Praticien $praticien): string
    {
        // TODO : prévoir le cas d'une mise à jour - le praticient possède déjà un ID
		$ID = Uuid::uuid4()->toString();
        $praticien->setID($ID);
        $this->praticiens[$ID] = $praticien;
        return $ID;
    }

    public function getPraticienById(string $id): Praticien
    {
        $praticien = $this->praticiens[$id] ??
            throw new RepositoryEntityNotFoundException("Praticien $id not found");

        return $praticien;
    }

    public function getAllPraticiens(): array
    {
        return $this->praticiens;
    }

}
<?php

namespace App\Models;

use Framework\Core\Model;

class Komentare extends Model
{
    protected ?int $ID_komentar = null;
    protected ?int $ID_hra = null;
    protected ?int $ID_pouzivatel = null;
    protected ?string $Popis;
    protected ?string $Datum_pridania;

    public function getIDKomentar(): ?int
    {
        return $this->ID_komentar;
    }

    public function setIDKomentar(int $ID_komentar): void
    {
        $this->ID_komentar = $ID_komentar;
    }

    public function getIDHra(): ?int
    {
        return $this->ID_hra;
    }

    public function setIDHra(int $ID_hra): void
    {
        $this->ID_hra = $ID_hra;
    }

    public function getIDPouzivatel(): ?int
    {
        return $this->ID_pouzivatel;
    }

    public function setIDPouzivatel(int $ID_pouzivatel): void
    {
        $this->ID_pouzivatel = $ID_pouzivatel;
    }

    public function getPopis(): ?string
    {
        return $this->Popis;
    }

    public function setPopis(string $Popis): void
    {
        $this->Popis = $Popis;
    }

    public function getDatumPridania(): ?string
    {
        return $this->Datum_pridania;
    }

    public function setDatumPridania(string $Datum_pridania): void
    {
        $this->Datum_pridania = $Datum_pridania;
    }
    public static function getCommentsByGame(int $gameId): array
    {
        return self::getAll('ID_hra = ?', [$gameId], 'Datum_pridania');
    }

}
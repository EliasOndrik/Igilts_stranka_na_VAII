<?php

namespace App\Models;

use Framework\Core\Model;

class Hry extends Model
{
    protected ?int $ID_hra = null;
    protected ?int $ID_nahravac;
    protected ?string $Nazov;
    protected ?string $Autor = "Neznámy";
    protected ?int $Hodnotenie;
    protected ?string $Popis;
    protected ?string $Obrazok;
    protected ?string $Datum_pridania;
    protected ?string $Link;

    public function getIDHra(): ?int
    {
        return $this->ID_hra;
    }

    public function setIDHra(int $ID_hra): void
    {
        $this->ID_hra = $ID_hra;
    }

    public function getNazov(): ?string
    {
        return $this->Nazov;
    }

    public function setNazov(string $Nazov): void
    {
        $this->Nazov = $Nazov;
    }

    public function getPopis(): ?string
    {
        return $this->Popis;
    }

    public function setPopis(string $Popis): void
    {
        $this->Popis = $Popis;
    }

    public function getObrazok(): ?string
    {
        return $this->Obrazok;
    }

    public function setObrazok(?string $Obrazok): void
    {
        $this->Obrazok = $Obrazok;
    }

    public function getDatumPridania(): ?string
    {
        return $this->Datum_pridania;
    }

    public function setDatumPridania(string $Datum_pridania): void
    {
        $this->Datum_pridania = $Datum_pridania;
    }

    public function getIDNahravac(): ?int
    {
        return $this->ID_nahravac;
    }

    public function setIDNahravac(?int $ID_nahravac): void
    {
        $this->ID_nahravac = $ID_nahravac;
    }

    public function getAutor(): ?string
    {
        return $this->Autor;
    }

    public function setAutor(?string $Autor): void
    {
        $this->Autor = $Autor;
    }

    public function getHodnotenie(): ?int
    {
        return $this->Hodnotenie;
    }

    public function setHodnotenie(?int $Hodnotenie): void
    {
        $this->Hodnotenie = $Hodnotenie;
    }

    public function getLink(): ?string
    {
        return $this->Link;
    }

    public function setLink(?string $Link): void
    {
        $this->Link = $Link;
    }
    public static function getGameByUploader(int $uploaderId): ?array
    {
        return self::getAll('ID_nahravac = ?', [$uploaderId]);
    }
}
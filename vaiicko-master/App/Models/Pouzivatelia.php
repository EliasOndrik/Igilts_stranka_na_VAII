<?php

namespace App\Models;

use Framework\Core\Model;

class Pouzivatelia extends Model
{
    protected ?int $ID_pouzivatel = null;
    protected ?string $Prezivka;
    protected ?string $Email;
    protected ?string $Heslo;
    protected ?string $Obrazok = "default.png";

    public function getIDPouzivatel(): ?int
    {
        return $this->ID_pouzivatel;
    }

    public function setIDPouzivatel(int $ID_Pouzivatel): void
    {
        $this->ID_pouzivatel = $ID_Pouzivatel;
    }

    public function getPrezivka(): ?string
    {
        return $this->Prezivka;
    }

    public function setPrezivka(string $Prezivka): void
    {
        $this->Prezivka = $Prezivka;
    }

    public function getHeslo(): ?string
    {
        return $this->Heslo;
    }

    public function setHeslo(string $Heslo): void
    {
        $this->Heslo = $Heslo;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $email): void
    {
        $this->Email = $email;
    }

    public function getObrazok(): ?string
    {
        return $this->Obrazok;
    }

    public function setObrazok(?string $Obrazok): void
    {
        $this->Obrazok = $Obrazok;
    }
    public function existsPrezivka(string $prezivka): bool
    {
        return self::getAll('prezivka = ?', [$prezivka])[0] !== null;
    }
    public function existsEmail(string $email): bool
    {
        return self::getAll('email = ?', [$email])[0] !== null;
    }
    public static function getObrazokPath(int $ID_pouzivatel): ?string
    {
        $pouzivatel = Pouzivatelia::getOne($ID_pouzivatel);
        return $pouzivatel?->getObrazok();
    }
}
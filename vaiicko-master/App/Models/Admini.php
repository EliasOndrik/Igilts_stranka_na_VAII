<?php

namespace App\Models;

use Framework\Core\Model;

class Admini extends Model
{
    private ?int $ID_admin = null;

    public function getIDAdmin(): ?int
    {
        return $this->ID_admin;
    }

    public function setIDAdmin(?int $ID_admin): void
    {
        $this->ID_admin = $ID_admin;
    }

    public static function isAdmin(?int $ID_pouzivatel): bool
    {
        return self::getOne($ID_pouzivatel) !== null;
    }

}
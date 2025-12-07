<?php

namespace App\Models;

use Framework\Core\Model;

class ZanreHry extends Model
{
    protected ?int $ID_hra = null;
    protected ?int $ID_zaner = null;


    public function getIDHra(): ?int
    {
        return $this->ID_hra;
    }

    public function setIDHra(?int $ID_hra): void
    {
        $this->ID_hra = $ID_hra;
    }

    public function getIDZaner(): ?int
    {
        return $this->ID_zaner;
    }

    public function setIDZaner(?int $ID_zaner): void
    {
        $this->ID_zaner = $ID_zaner;
    }
}
<?php

namespace App\Models;

use Framework\Core\Model;

class Zaner extends Model
{
    protected ?int $ID_zaner = null;
    protected ?string $Zaner;

    public function getIDZaner(): ?int
    {
        return $this->ID_zaner;
    }

    public function setIDZaner(?int $ID_zaner): void
    {
        $this->ID_zaner = $ID_zaner;
    }

    public function getZaner(): ?string
    {
        return $this->Zaner;
    }

    public function setZaner(?string $Zaner): void
    {
        $this->Zaner = $Zaner;
    }

}
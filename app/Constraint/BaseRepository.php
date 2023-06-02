<?php

namespace App\Constraint;

use Illuminate\Database\Eloquent\Model;

interface BaseRepository
{
    public function getModel(): Model;
}

<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken;

class Token extends PersonalAccessToken
{
    public function model()
    {
        return $this->morphTo('model');
    }

    public function tokenable()
    {
        return $this->model();
    }
}

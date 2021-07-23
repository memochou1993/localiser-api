<?php

namespace App\Models\Traits;

use App\Models\Token;

trait HasTokens
{
    public function tokens()
    {
        return $this->morphMany(Token::class, 'model');
    }
}

<?php

namespace App\Models;

use App\Models\Traits\HasHashId;
use Laravel\Sanctum\PersonalAccessToken;

class Token extends PersonalAccessToken
{
    use HasHashId;

    public function model()
    {
        return $this->morphTo('model');
    }

    public function tokenable()
    {
        return $this->model();
    }

    /**
     * Find the token instance matching the given token.
     *
     * @param  string  $token
     * @return static|null
     */
    public static function findToken($token)
    {
        if (strpos($token, '|') === false) {
            return static::where('token', hash('sha256', $token))->first();
        }

        [$id, $token] = explode('|', $token, 2);

        $decoded = hash_id((new Token())->getTable())->decodeHex($id);

        if ($instance = static::find($decoded)) {
            return hash_equals($instance->token, hash('sha256', $token)) ? $instance : null;
        }
    }
}

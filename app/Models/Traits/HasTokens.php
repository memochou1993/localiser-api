<?php

namespace App\Models\Traits;

use App\Models\Token;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;

trait HasTokens
{
    public function tokens()
    {
        return $this->morphMany(Token::class, 'model');
    }

    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createToken(string $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
        ]);

        $prefix = $token->getAttribute('hash_id') ?? $token->getKey();

        return new NewAccessToken($token, $prefix.'|'.$plainTextToken);
    }
}

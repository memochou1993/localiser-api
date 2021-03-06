<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\App;

trait HasHashId
{
    public function getHashIdAttribute()
    {
        return hash_id($this->getTable())->encodeHex($this->getKey());
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if (App::environment('local') && is_numeric($value)) {
            return parent::resolveRouteBinding($value);
        }
        return parent::resolveRouteBinding(hash_id($this->getTable())->decodeHex($value));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValueStoreRequest;
use App\Http\Requests\ValueUpdateRequest;
use App\Http\Resources\ValueResource;
use App\Models\Key;
use App\Models\Value;

class ValueController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct() {
        $this->authorizeResource(Value::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ValueStoreRequest $request
     * @param Key $key
     * @return ValueResource
     */
    public function store(ValueStoreRequest $request, Key $key): ValueResource
    {
        /** @var Value $value */
        $value = Value::query()->make($request->all());

        $key->values()->save($value);

        return new ValueResource($value);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ValueUpdateRequest $request
     * @param Value $value
     * @return ValueResource
     */
    public function update(ValueUpdateRequest $request, Value $value): ValueResource
    {
        $value->update($request->all());

        return new ValueResource($value);
    }
}

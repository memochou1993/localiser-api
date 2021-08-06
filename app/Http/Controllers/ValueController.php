<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValueIndexRequest;
use App\Http\Requests\ValueStoreRequest;
use App\Http\Requests\ValueUpdateRequest;
use App\Http\Resources\ValueResource;
use App\Models\Key;
use App\Models\Value;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ValueController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct() {
        $this->authorizeResource(Value::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ValueIndexRequest $request
     * @param Key $key
     * @return AnonymousResourceCollection
     */
    public function index(ValueIndexRequest $request, Key $key): AnonymousResourceCollection
    {
        $values = $key->values()->with(['language'])->get();

        return ValueResource::collection($values);
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
        $key->project()->touch();

        $key->touch();

        $value = $key->values()->create($request->all());

        return new ValueResource($value);
    }

    /**
     * Display the specified resource.
     *
     * @param Value $value
     * @return ValueResource
     */
    public function show(Value $value): ValueResource
    {
        return new ValueResource(Value::with(['language'])->find($value->id));
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
        $value->key->project()->touch();

        $value->key()->touch();

        $value->update($request->all());

        return new ValueResource($value);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Value $value
     * @return JsonResponse
     */
    public function destroy(Value $value): JsonResponse
    {
        $value->key->project()->touch();

        $value->key()->touch();

        $value->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

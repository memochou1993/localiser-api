<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'languages' => LanguageResource::collection($this->whenLoaded('languages')),
            'roles' => $this->when($this->pivot, function () {
                return json_decode($this->pivot->roles);
            }),
            'abilities' => $this->when($this->pivot, function () {
                return collect(json_decode($this->pivot->roles))
                    ->map(function ($role) {
                        return config('roles')[$role];
                    })
                    ->collapse()
                    ->unique()
                    ->values();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

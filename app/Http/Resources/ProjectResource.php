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
            'role' => $this->when($this->pivot, function () {
                return config('roles')[$this->pivot->role];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

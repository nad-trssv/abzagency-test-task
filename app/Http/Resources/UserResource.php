<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            "id"                    => $this->id,
            "name"                  => $this->name,
            "phone"                 => $this->phone,
            "position_id"           => $this->position_id,
            "position"              => $this->position->name,
            "email"                 => $this->email,
            'photo' => $this->photo ? Storage::url($this->photo) : asset('assets/images/no-image.jpg'),
            'create_date'           => Carbon::parse($this->create_date)->format(env('DATETIME_FORMAT')),
            'update_date'           => Carbon::parse($this->update_date)->format(env('DATETIME_FORMAT')),
        ];
    }
}

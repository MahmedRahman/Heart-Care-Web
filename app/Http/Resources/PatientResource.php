<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'hospital_id' => $this->hospital_id,
            'profile_image' => $this->profile_image ? asset('storage/' . $this->profile_image) : null,
            'country' => $this->country,
            'city' => $this->city,
            'address_area' => $this->address_area,
            'address_street' => $this->address_street,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'gender' => $this->gender,
            'age' => $this->age,
            'race' => $this->race,
            'weight' => $this->weight,
            'height' => $this->height,
            'bsa' => $this->bsa,
            'bmi' => $this->bmi,
            'marital_state' => $this->marital_state,
            'language' => $this->language,
            'primary_diagnosis' => $this->primary_diagnosis,
            'secondary_diagnosis' => $this->secondary_diagnosis,
            'tertiary_diagnosis' => $this->tertiary_diagnosis,
            'next_of_kin' => $this->next_of_kin,
            'next_of_kin_phone' => $this->next_of_kin_phone,
            'next_of_kin_email' => $this->next_of_kin_email,
            'clinic_name' => $this->clinic_name,
            'physician_team_name' => $this->physician_team_name,
            'nurse_name' => $this->nurse_name,
            'email_verified' => $this->email_verified,
            'mobile_verified' => $this->mobile_verified,
            'profile_completion_percentage' => $this->profile_completion_percentage,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}

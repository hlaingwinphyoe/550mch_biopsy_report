<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateAspirateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('update',$this->route('aspirate'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "sc_date" => 'required|date',
            "lab_access" => 'required|numeric',
            "patient_name" => 'required|min:3',
            "age" => 'required|numeric|max:100',
            "age_type" => 'required',
            "specimen_type" => "required|min:3",
            "price" => "required|numeric",
            "gender" => 'required',
            "contact_detail" => 'nullable|min:3',
            "physician_name" => 'required|min:3',
            "doctor" => 'required|min:3',
            "clinical_history" => 'nullable|min:3',
            "bmexamination" => 'nullable|min:3',
            "pro_perform" => 'required',
            "anatomic_site_aspirate" => 'nullable|min:3',
            "ease_diff_aspirate" => 'nullable|min:3',
            "blood_count" => 'nullable|min:3',
            "blood_smear" => 'nullable|min:3',
            "cellular_particles" => 'nullable|min:3',
            "nucleated_differential" => 'nullable|min:3',
            "total_cell_count" => 'nullable|min:3',
            "myeloid" => 'nullable|min:3',
            "erythropoiesis" => 'nullable|min:3',
            "myelopoiesis" => 'nullable|min:3',
            "megakaryocytes" => 'nullable|min:3',
            "lymphocytes" => 'nullable|min:3',
            "plasma_cell" => 'nullable|min:3',
            "haemopoietic_cell" => 'nullable|min:3',
            "abnormal_cell" => 'nullable|min:3',
            "iron_stain" => 'nullable|min:3',
            "cytochemistry" => 'nullable|min:3',
            "investigation" => 'nullable|min:3',
            "flow_cytometry" => 'nullable|min:3',
            "conclusion" => 'nullable|min:3',
            "classification" => 'nullable|min:3',
            "disease_code" => 'nullable|min:3',
            "hospital" => 'required|integer|exists:hospitals,id'
        ];
    }
}

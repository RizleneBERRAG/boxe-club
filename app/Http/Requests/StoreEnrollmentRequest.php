<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required','string','max:120'],
            'last_name'  => ['required','string','max:120'],
            'email'      => ['required','email','max:190'],
            'phone'      => ['nullable','string','max:40'],

            'birthdate'  => ['required','date','before:tomorrow'],
            'plan_id'    => ['required', Rule::exists('plans','id')->where('is_active',1)],

            // calculé dans prepareForValidation()
            'is_minor'   => ['boolean'],

            // requis si mineur
            'parent_name'=> ['required_if:is_minor,1','nullable','string','max:190'],
            'parent_date'=> ['required_if:is_minor,1','nullable','date'],

            'rgpd'       => ['accepted'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $isMinor = false;

        if ($this->filled('birthdate')) {
            $b = Carbon::parse($this->input('birthdate'));
            $isMinor = $b->diffInYears(Carbon::today()) < 18;
        }

        $this->merge([
            'is_minor' => $isMinor,
        ]);
    }

    public function messages(): array
    {
        return [
            'parent_name.required_if' => "Le nom du parent est requis pour un mineur.",
            'parent_date.required_if' => "La date de signature parentale est requise pour un mineur.",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $currentYear = date('Y');
        
        return [
            'brand_id' => 'nullable|integer|exists:brands,id',
            'model_id' => 'nullable|integer|exists:car_models,id',
            'body_type_id' => 'nullable|integer|exists:body_types,id',
            'year_from' => [
                'nullable',
                'integer',
                'min:1990',
                'max:' . ($currentYear + 1)
            ],
            'year_to' => [
                'nullable',
                'integer',
                'min:1990',
                'max:' . ($currentYear + 1)
            ],
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
            'page' => 'nullable|integer|min:1',
            'sort' => 'nullable|string|in:price_asc,price_desc,year_asc,year_desc,mileage_asc,mileage_desc',
            'per_page' => 'nullable|integer|min:1|max:50'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'brand_id.exists' => 'Selected brand does not exist.',
            'model_id.exists' => 'Selected model does not exist.',
            'body_type_id.exists' => 'Selected body type does not exist.',
            'year_from.min' => 'Year cannot be less than 1990.',
            'year_from.max' => 'Year cannot be greater than current year.',
            'year_to.min' => 'Year cannot be less than 1990.',
            'year_to.max' => 'Year cannot be greater than current year.',
            'price_min.min' => 'Price cannot be negative.',
            'price_max.min' => 'Price cannot be negative.',
            'page.min' => 'Page number must be greater than 0.',
            'per_page.min' => 'Number of items per page must be greater than 0.',
            'per_page.max' => 'Number of items per page cannot be greater than 50.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateYearRange($validator);
            $this->validatePriceRange($validator);
        });
    }

    /**
     * Validate year range
     */
    private function validateYearRange($validator)
    {
        $yearFrom = $this->input('year_from');
        $yearTo = $this->input('year_to');

        if ($yearFrom && $yearTo && $yearFrom > $yearTo) {
            $validator->errors()->add('year_from', 'Year "from" cannot be greater than year "to"');
        }
    }

    /**
     * Validate price range
     */
    private function validatePriceRange($validator)
    {
        $priceMin = $this->input('price_min');
        $priceMax = $this->input('price_max');

        if ($priceMin && $priceMax && $priceMin > $priceMax) {
            $validator->errors()->add('price_min', 'Price "from" cannot be greater than price "to"');
        }
    }

    /**
     * Get validated data from the request.
     */
    public function getValidatedFilters(): array
    {
        return $this->only([
            'brand_id',
            'model_id', 
            'body_type_id',
            'year_from',
            'year_to',
            'price_min',
            'price_max',
            'sort',
            'per_page'
        ]);
    }
} 
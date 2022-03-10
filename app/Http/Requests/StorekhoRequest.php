<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-08 00:00:53
 * File: kho.php
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorekhoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ten_kho' => 'nullable|string|max:191',
            'dia_chi' => 'nullable|string|max:191',
            'mo_ta' => 'nullable|string|max:191',
            'ma_kho' => 'nullable|string|max:191',
            //{{REQUEST_RULES_NOT_DELETE_THIS_LINE}}
        ];
    }
}

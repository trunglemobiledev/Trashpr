<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-07 23:47:52
 * File: nhacCungCap.php
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorenhacCungCapRequest extends FormRequest
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
            'man_nha_cung_cap' => 'nullable|string|max:191',
            'ten_nhac_cung_cap' => 'nullable|string|max:191',
            'dia_chi' => 'nullable|string|max:191',
            'so_dien_thoai' => 'nullable|string|max:191',
            'tk_ngan_hang' => 'nullable|string|max:191',
            //{{REQUEST_RULES_NOT_DELETE_THIS_LINE}}
        ];
    }
}

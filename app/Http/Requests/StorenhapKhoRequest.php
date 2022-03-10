<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-08 00:10:12
 * File: nhapKho.php
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorenhapKhoRequest extends FormRequest
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
            'ngay_nhap' => 'nullable|date_format:Y-m-d H:i:s',
            'so_luong' => 'nullable|numeric',
            'ma_phieu_nhap' => 'nullable|string|max:191',
            //{{REQUEST_RULES_NOT_DELETE_THIS_LINE}}
        ];
    }
}

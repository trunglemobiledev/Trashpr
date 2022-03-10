<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-08 00:15:37
 * File: xuatKho.php
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorexuatKhoRequest extends FormRequest
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
            'ma_phieu_xuat' => 'nullable|string|max:191',
            'ngay_xuat' => 'nullable|date_format:Y-m-d H:i:s',
            'so_luong' => 'nullable|string|max:191',
            //{{REQUEST_RULES_NOT_DELETE_THIS_LINE}}
        ];
    }
}

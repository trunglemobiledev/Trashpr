<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-07 23:32:32
 * File: sanpham.php
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoresanphamRequest extends FormRequest
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
            'ma_san_pham' => 'nullable|string|max:191',
            'ten_san_pham' => 'nullable|string|max:191',
            'gia_nhap' => 'nullable|numeric',
            'gia_ban' => 'nullable|numeric',
            'ten_khach_ban' => 'nullable|string|max:191',
            'so_dien_thoai_khach_ban' => 'nullable|string|max:191',
            'hinh_anh' => 'nullable|string|max:191',
            'so_may' => 'nullable|string|max:191',
            'don_vi_tinh' => 'nullable|string|max:191',
            'tinh_trang_bao_hanh' => 'nullable|string|max:191',
            'ho_so' => 'nullable|string|max:191',
            'ngay_mua' => 'nullable|date_format:Y-m-d H:i:s',
            'mo_ta' => 'nullable|string',
            //{{REQUEST_RULES_NOT_DELETE_THIS_LINE}}
        ];
    }
}

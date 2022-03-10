<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-07 23:32:32
 * File: sanpham.php
 */
namespace App\Models;



class sanpham extends BaseModel
{
	

    //Declare table name
    protected $table = 'sanphams';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
        'ma_san_pham',
        'ten_san_pham',
        'gia_nhap',
        'gia_ban',
        'ten_khach_ban',
        'so_dien_thoai_khach_ban',
        'hinh_anh',
        'so_may',
        'don_vi_tinh',
        'tinh_trang_bao_hanh',
        'ho_so',
        'ngay_mua',
        'mo_ta',
        'danh_muc_id',
        'thuong_hieu_id',
        'nhac_cung_cap_id',
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function danhMuc(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(danhMuc::class, 'danh_muc_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function thuongHieu(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(thuongHieu::class, 'thuong_hieu_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function nhacCungCap(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(nhacCungCap::class, 'nhac_cung_cap_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     **/
    public function nhapKhos(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(nhapKho::class, 'ref_nhap_kho_sanpham', 'sanpham_id', 'nhap_kho_id');
    }

    //{{RELATIONS_NOT_DELETE_THIS_LINE}}
}

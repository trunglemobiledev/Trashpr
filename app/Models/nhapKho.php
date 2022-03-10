<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-08 00:10:12
 * File: nhapKho.php
 */
namespace App\Models;



class nhapKho extends BaseModel
{
	

    //Declare table name
    protected $table = 'nhap_khos';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
        'ngay_nhap',
        'so_luong',
        'ma_phieu_nhap',
        'kho_id',
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     **/
    public function sanphams(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(sanpham::class, 'ref_nhap_kho_sanpham', 'nhap_kho_id', 'sanpham_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function kho(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(kho::class, 'kho_id', 'id');
    }

    //{{RELATIONS_NOT_DELETE_THIS_LINE}}
}

<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-08 00:15:37
 * File: xuatKho.php
 */
namespace App\Models;



class xuatKho extends BaseModel
{
	

    //Declare table name
    protected $table = 'xuat_khos';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
        'ma_phieu_xuat',
        'ngay_xuat',
        'so_luong',
        'kho_id',
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function kho(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(kho::class, 'kho_id', 'id');
    }

    //{{RELATIONS_NOT_DELETE_THIS_LINE}}
}

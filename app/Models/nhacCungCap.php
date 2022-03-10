<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-07 23:47:52
 * File: nhacCungCap.php
 */
namespace App\Models;



class nhacCungCap extends BaseModel
{
	

    //Declare table name
    protected $table = 'nhac_cung_caps';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
    	'man_nha_cung_cap',
        'ten_nhac_cung_cap',
        'dia_chi',
        'so_dien_thoai',
        'tk_ngan_hang',
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function sanphams(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(sanpham::class, 'nhac_cung_cap_id', 'id');
    }

    //{{RELATIONS_NOT_DELETE_THIS_LINE}}
}

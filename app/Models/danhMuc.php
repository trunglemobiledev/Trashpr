<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-07 23:41:40
 * File: danhMuc.php
 */
namespace App\Models;



class danhMuc extends BaseModel
{
	

    //Declare table name
    protected $table = 'danh_mucs';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
    	'ten_danh_muc',
        'mo_ta',
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function sanphams(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(sanpham::class, 'danh_muc_id', 'id');
    }

    //{{RELATIONS_NOT_DELETE_THIS_LINE}}
}

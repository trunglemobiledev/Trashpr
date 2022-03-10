<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-07 23:38:19
 * File: thuongHieu.php
 */
namespace App\Models;



class thuongHieu extends BaseModel
{
	

    //Declare table name
    protected $table = 'thuong_hieus';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
    	'ten_hang',
        'mo_ta',
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function sanphams(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(sanpham::class, 'thuong_hieu_id', 'id');
    }

    //{{RELATIONS_NOT_DELETE_THIS_LINE}}
}

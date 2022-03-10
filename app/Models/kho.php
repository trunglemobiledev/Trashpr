<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-08 00:00:53
 * File: kho.php
 */
namespace App\Models;



class kho extends BaseModel
{
	

    //Declare table name
    protected $table = 'khos';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
    	'ten_kho',
        'dia_chi',
        'mo_ta',
        'ma_kho',
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function nhapKhos(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(nhapKho::class, 'kho_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function xuatKhos(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(xuatKho::class, 'kho_id', 'id');
    }

    //{{RELATIONS_NOT_DELETE_THIS_LINE}}
}

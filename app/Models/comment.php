<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-10 00:23:36
 * File: comment.php
 */
namespace App\Models;



class comment extends BaseModel
{
	

    //Declare table name
    protected $table = 'comments';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
    	'name',
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     **/
    public function posts(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(post::class, 'ref_post_comment', 'comment_id', 'post_id');
    }

    //{{RELATIONS_NOT_DELETE_THIS_LINE}}
}

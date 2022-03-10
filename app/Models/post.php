<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-10 00:21:11
 * File: post.php
 */
namespace App\Models;



class post extends BaseModel
{
	

    //Declare table name
    protected $table = 'posts';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
    	'name',
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     **/
    public function comments(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(comment::class, 'ref_post_comment', 'post_id', 'comment_id');
    }

    //{{RELATIONS_NOT_DELETE_THIS_LINE}}
}

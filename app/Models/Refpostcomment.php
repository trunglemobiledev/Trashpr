<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-10 00:24:18
 * File: Refpostcomment.php
 */
namespace App\Models;

//{{USE_CLASS_NOT_DELETE_THIS_LINE}}

class Refpostcomment extends BaseModel
{
	//{{USE_NOT_DELETE_THIS_LINE}}

    //Declare table name
    protected $table = 'ref_post_comment';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
    	'comment_id',
        'post_id',
    ];

    

	//{{RELATIONS_NOT_DELETE_THIS_LINE}}
}

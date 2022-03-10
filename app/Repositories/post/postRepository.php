<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-10 00:21:11
 * File: post.php
 */

namespace App\Repositories\post;

use App\Models\post;
use App\Repositories\EloquentRepository;

class postRepository extends EloquentRepository implements postInterface
{
	public function getModel(): string
	{
		return post::class;
	}
}
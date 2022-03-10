<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-10 00:23:36
 * File: comment.php
 */

namespace App\Repositories\comment;

use App\Models\comment;
use App\Repositories\EloquentRepository;

class commentRepository extends EloquentRepository implements commentInterface
{
	public function getModel(): string
	{
		return comment::class;
	}
}
<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-08 00:00:53
 * File: kho.php
 */

namespace App\Repositories\kho;

use App\Models\kho;
use App\Repositories\EloquentRepository;

class khoRepository extends EloquentRepository implements khoInterface
{
	public function getModel(): string
	{
		return kho::class;
	}
}
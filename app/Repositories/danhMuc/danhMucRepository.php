<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-07 23:41:40
 * File: danhMuc.php
 */

namespace App\Repositories\danhMuc;

use App\Models\danhMuc;
use App\Repositories\EloquentRepository;

class danhMucRepository extends EloquentRepository implements danhMucInterface
{
	public function getModel(): string
	{
		return danhMuc::class;
	}
}
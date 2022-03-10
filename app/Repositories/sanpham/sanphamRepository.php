<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-07 23:32:32
 * File: sanpham.php
 */

namespace App\Repositories\sanpham;

use App\Models\sanpham;
use App\Repositories\EloquentRepository;

class sanphamRepository extends EloquentRepository implements sanphamInterface
{
	public function getModel(): string
	{
		return sanpham::class;
	}
}
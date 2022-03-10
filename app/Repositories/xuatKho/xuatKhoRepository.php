<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-08 00:15:37
 * File: xuatKho.php
 */

namespace App\Repositories\xuatKho;

use App\Models\xuatKho;
use App\Repositories\EloquentRepository;

class xuatKhoRepository extends EloquentRepository implements xuatKhoInterface
{
	public function getModel(): string
	{
		return xuatKho::class;
	}
}
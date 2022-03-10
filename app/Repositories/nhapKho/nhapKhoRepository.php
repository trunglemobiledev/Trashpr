<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-08 00:10:12
 * File: nhapKho.php
 */

namespace App\Repositories\nhapKho;

use App\Models\nhapKho;
use App\Repositories\EloquentRepository;

class nhapKhoRepository extends EloquentRepository implements nhapKhoInterface
{
	public function getModel(): string
	{
		return nhapKho::class;
	}
}
<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-07 23:47:52
 * File: nhacCungCap.php
 */

namespace App\Repositories\nhacCungCap;

use App\Models\nhacCungCap;
use App\Repositories\EloquentRepository;

class nhacCungCapRepository extends EloquentRepository implements nhacCungCapInterface
{
	public function getModel(): string
	{
		return nhacCungCap::class;
	}
}
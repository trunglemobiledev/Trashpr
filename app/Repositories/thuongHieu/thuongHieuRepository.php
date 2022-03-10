<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2022-03-07 23:38:19
 * File: thuongHieu.php
 */

namespace App\Repositories\thuongHieu;

use App\Models\thuongHieu;
use App\Repositories\EloquentRepository;

class thuongHieuRepository extends EloquentRepository implements thuongHieuInterface
{
	public function getModel(): string
	{
		return thuongHieu::class;
	}
}
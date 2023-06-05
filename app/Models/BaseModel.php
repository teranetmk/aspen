<?php

namespace Aspen\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
	public function scopeForLoggedInUser($query)
	{
		$query->where('pharmacist_id', get_user_meta(get_current_user_id(), 'pharmacist_id', true));
	}
}

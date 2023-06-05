<?php

namespace Aspen\Models;

class User extends BaseModel
{
	protected $table = 'users';

	public function meta()
	{
		return $this->hasMany(UserMeta::class, 'user_id', 'ID');
	}

	public function getMetadataAttribute()
	{
		return $this->meta->pluck('meta_value', 'meta_key');
	}

	public function scopeHasMeta($query, $key)
	{
		return $query->whereRelation('meta', 'meta_key', $key);
	}

	public function scopeWhereMeta($query, $key, $val)
	{
		return $query->whereHas('meta', function ($query) use ($key, $val) {
			$query->where([
				'meta_key'   => $key,
				'meta_value' => $val,
			]);
		});
	}

	public function scopeWithMeta($query, $key)
	{
		return $query->with(['meta' => function ($query) use ($key) {
			$query->where('meta_key', $key);
		}]);
	}
}

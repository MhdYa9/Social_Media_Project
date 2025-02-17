<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Corner
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $user_id
 * @property string $cover_image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|User[] $users
 * @property Collection|Post[] $posts
 *
 * @package App\Models
 */
class Corner extends Model
{
	protected $table = 'corners';


	protected $fillable = [
		'name',
		'description',
		'user_id',
		'cover_image'
	];

	public function owner()
	{
		return $this->belongsTo(User::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class)
					->withPivot('type')
					->withTimestamps();
	}

	public function posts()
	{
		return $this->hasMany(Post::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @property int $id
 * @property int $user_id
 * @property string $commentable_type
 * @property int $commentable_id
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 *
 * @package App\Models
 */
class Comment extends Model
{
	protected $table = 'comments';


	protected $fillable = [
		'user_id',
		'commentable_type',
		'commentable_id',
		'content'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

    public function commentable(){
        return $this->morphTo();
    }

    public function replies(){
        return $this->morphMany(Comment::class, 'commentable');
    }
}

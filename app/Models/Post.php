<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property bool $is_pinned
 * @property int $user_id
 * @property int|null $corner_id
 * @property string $privacy
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Corner|null $corner
 * @property User $user
 * @property SavedPost $saved_post
 * @property Collection|Share[] $shares
 *
 * @package App\Models
 */
class Post extends Model
{
	use SoftDeletes,Sluggable;
	protected $table = 'posts';

	protected $fillable = [
		'title',
		'slug',
		'body',
		'is_pinned',
		'user_id',
		'corner_id',
		'privacy'
	];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title' // Ensure this is set to 'title'
            ]
        ];
    }

	public function corner()
	{
		return $this->belongsTo(Corner::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function saved_by()
	{
        return $this->belongsToMany(User::class,'saved_posts','post_id','user_id');
	}


	public function shares()
	{
		return $this->belongsToMany(Post::class,'posts','shared_post_id','post_id');
	}

    public function sharedPost(){
        return $this->hasOne(Post::class,'shared_post_id');
    }


}

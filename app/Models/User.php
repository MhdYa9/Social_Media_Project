<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $user_name
 * @property string|null $bio
 * @property string $email
 * @property string|null $profile_image
 * @property string|null $cover_image
 * @property Carbon|null $birthday
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_verified
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Bolck[] $bolcks
 * @property Collection|Comment[] $comments
 * @property Collection|Corner[] $corners
 * @property Collection|Post[] $posts
 * @property Collection|Reaction[] $reactions
 * @property Collection|Share[] $shares
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'birthday' => 'datetime',
		'email_verified_at' => 'datetime',
		'is_verified' => 'bool'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'user_name',
		'bio',
		'email',
		'profile_image',
		'cover_image',
		'birthday',
	];


	public function blockedPeople()
	{
		return $this->belongsToMany(User::class, 'blocks', 'user_id', 'blocked_id');
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function owned_corners()
	{
		return $this->hasMany(Corner::class);
	}

    public function corners()
    {
        return $this->belongsToMany(Corner::class)
            ->withPivot('type')
            ->withTimestamps()  ;
    }

	public function relatedTo()
	{
        return $this->belongsToMany(User::class, 'relationships', 'user_id', 'related_id');
	}

    public function relations()
    {
        return $this->belongsToMany(User::class, 'relationships', 'related_id', 'user_id');
    }

	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function reactions()
	{
		return $this->belongsToMany(Post::class, 'reactions', 'user_id', 'post_id')
            ->withPivot('type')
            ->withTimestamps();
	}

	public function saved_posts()
	{
        return $this->belongsToMany(Post::class, 'saved_posts', 'user_id', 'post_id');
	}


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'uuid',
        'media_seek',
        'play_timestamp',
        'user_id',
        'user_file_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roomUsers()
    {
        return $this->hasManyThrough(User::class, RoomUser::class);
    }

    public function userFile() {
        return $this->belongsTo(UserFile::class);
    }
}

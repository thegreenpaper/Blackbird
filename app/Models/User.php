<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'display_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function friendships(): BelongsToMany
    {
        return $this->belongsToMany(Friendship::class);
    }

    // these should maybe be in a controller, but they are related to getting date, so it's ok ish
    public function getOtherUsersFromFriends()
    {
        $users = [];

        foreach ($this->friendships as $friend) {
            $toAdd = $friend->users()->get();

            foreach ($toAdd as $user) {
                if ($this->id !== $user->id)
                    array_push($users, $user);
            }

        }

        return $users;
    }

    public function getPendingFriendshipsUsers()
    {
        $friendships = [];

        foreach ($this->friendships as $friend) {
            $toAdd = [];

            if ($friend->pending) {
                $users = [];

                foreach ($friend->users()->get() as $toAdd) {
                    array_push($users, $toAdd->username);
                }
                array_push($users, $friend->pending);
                array_push($users, $friend->id);
                array_push($friendships, $users);
            }
        }

        return $friendships;
    }

    public function getFriendshipsAndChannels()
    {
        $friendshipsAndChannels = [];

        foreach ($this->friendships as $friend) {
            if ($friend->pending == null) {
                $userAndChannel = [];
                // channel id
                array_push($userAndChannel, $friend->id);

                foreach ($friend->users()->get() as $user) {
                    if ($user->id !== $this->id) {
                        array_push($userAndChannel, $user->username);
                    }
                }
                array_push($friendshipsAndChannels, $userAndChannel);
            }

        }
        return $friendshipsAndChannels;
    }
}

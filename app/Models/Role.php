<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Represents a role in the application.
 *
 */
class Role extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * @var string[]
     */
    protected $fillable = ['name'];


    /**
     * The users that belong to the role.
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
}



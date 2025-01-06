<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Permission extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = [
        'name',
        'description'
    ];

    // Define the relationship with Profile
    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'profile_permission');
    }

}

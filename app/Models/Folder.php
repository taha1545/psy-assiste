<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    /** @use HasFactory<\Database\Factories\FolderFactory> */
    use HasFactory;

    protected $fillable = [
        'folder_name',
        'full_address',
        'birth_date',
        'region',
        'phone_number',
        'family_number',
        'total_siblings',
        'sibling_position',
        'start_date',
        'education_level',
        'user_id'
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

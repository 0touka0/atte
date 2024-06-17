<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Break_;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'start', 'end'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breaktimes()
    {
        return $this->hasMany(BreakTime::class);
    }
}

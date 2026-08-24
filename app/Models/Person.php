<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $primaryKey = 'person_code';
    protected $fillable = ['person_code', 'name', 'mail', 'age'];

    // リレーション定義
    public function comments()
    {
      return $this->hasMany(Comment::class, 'person_id', 'person_code');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkillSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['candidate_id','skill_id', 'deleted_at'];
}
